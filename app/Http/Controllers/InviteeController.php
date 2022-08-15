<?php

namespace App\Http\Controllers;

use App\Mail\GenericMail;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Invitee;
use App\Models\Role;
use App\Models\User;
use App\Rules\StandardPassword;
use App\Services\MailApiService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;

class InviteeController extends Controller
{
    //

    public function getProtectedRoles()
    {
        $protectedRoleNames = ['owner_super_admin'];
        $protectedRoles = DB::table('roles')->whereIn('name', $protectedRoleNames)->get();
        return $protectedRoles;
    }
    public function showInvitees()
    {
        $user = auth()->user();
        $business = $user->business;
        $invitees = Invitee::whereBusinessId($business->id)->with('role')->get();
        return $this->sendSuccess("Invitees fetched successfully", [
            "invitees" => $invitees
        ]);
    }

    public function sendInvites(Request $request)
    {

        $request->validate([
            "window_location" => "required|string|url",
            "invitations" => "required|array",
            "invitations.*.email" => "required|email",
            "invitations.*.role_id" => "required|exists:roles,id"
        ]);

        // Do Not Assign Protected Roles
        $protectedRoleIds = $this->getProtectedRoles()->pluck('id')->toArray();
        collect($request->invitations)->map(function ($invitation) use ($protectedRoleIds) {
            if (in_array($invitation['role_id'], $protectedRoleIds)) {
                response()->json(["status" => false, "message" => "Cannot assign protected role id: " . $invitation['role_id'], "data" => []], 403)->throwResponse();
            }
        });

        $user = auth()->user();
        $business = $user->business;
        $this->checkAuthorization($user, $business);
        $window_location = $request->window_location;

        // Good to go.
        $invitees = collect($request->invitations)->map(function ($invitation) use ($business, $user, $window_location) {
            $code = rand(10, 99) . rand(10, 99) . rand(10, 99);

            // Don't send to invitor
            if ($invitation["email"] == $user->email) {
                return;
            }
            $alreadyInvited = Invitee::whereEmail($invitation["email"])
                ->whereBusinessId($business->id)
                ->first();

            // Don't send to already created invitee 
            if ($alreadyInvited
                // && $alreadyInvited->status == 1
            ) {
                return;
            }
            $role = Role::find($invitation["role_id"]);
            $invitee = Invitee::updateOrCreate([
                "business_id" => $business->id,
                "email" => $invitation["email"]
            ], [
                "business_id" => $business->id,
                "email" => $invitation["email"],
                "code" => $code,
                "host_user_id" => $user->id,
                "role_id" => $invitation["role_id"],
                "status" => 0,
            ]);

            $mailing = $this->notifyInvitee($invitee, $business, $user, $role, $window_location);

            return $invitee;
        });

        return $this->sendSuccess('Invitations sent successfully');
    }

    public function resendInvite(Request $request)
    {
        $request->validate([
            "invitee_id" => "required|exists:invitees,id",
            "window_location" => "required|string|url",
        ]);

        $user = auth()->user();
        $business = $user->business;
        $this->checkAuthorization($user, $business);
        $window_location = $request->window_location;

        // Make sure invitee exists and can be updated
        $invitee = Invitee::whereId($request->invitee_id)->whereBusinessId($business->id)->first();
        if (!$invitee) {
            return $this->sendError('Invitee not found for this business', [], 404);
        }

        if ($invitee->status != 0) {
            return $this->sendError("This invitation has already been accepted.", [], 403);
        }

        $mailing = $this->notifyInvitee($invitee, $business, $user, $window_location);
    }

    public function updateRole(Request $request)
    {
        $request->validate([
            "invitee_id" => "required|exists:invitees,id",
            "role_id" => "required|exists:roles,id"
        ]);

        // Do Not Assign Protected Roles
        $protectedRoleIds = $this->getProtectedRoles()->pluck('id')->toArray();
        if (in_array($request->role_id, $protectedRoleIds)) {
            return $this->sendError('Cannot assign protected role id: ' . $request->role_id, [], 403);
        }

        $user = auth()->user();
        $business = $user->business;

        $this->checkAuthorization($user, $business);


        // Make sure invitee exists and can be updated
        $invitee = Invitee::whereId($request->invitee_id)->whereBusinessId($business->id)->first();
        if (!$invitee) {
            return $this->sendError('Invitee not found for this business', [], 404);
        }
        $invitee->role_id = $request->role_id;
        $invitee->save();

        // Update Business User record if invitee exists as a user
        $inviteeUser = User::whereEmail($invitee->email)->first();
        if ($inviteeUser) {
            $inviteeBusinessUser = BusinessUser::whereUserId($inviteeUser->id)
                ->whereBusinessId($business->id)->first();
            $inviteeBusinessUser->role_id = $request->role_id;
            $inviteeBusinessUser->save();

            // Resync roles on Business User
            $role = Role::find($request->role_id);
            $inviteeBusinessUser->syncRoles([$role->name]);
        }

        return $this->sendSuccess("Invitee Role updated successfully", [
            "invitee" => $invitee
        ]);
    }

    public function toggleActivity(Request $request)
    {
        $request->validate([
            "invitee_id" => "required|exists:invitees,id",
            "activity" => "required|string|in:enable,disable",
        ]);
        $user = auth()->user();
        $business = $user->business;
        $this->checkAuthorization($user, $business);


        // Make sure invitee exists and can be updated
        $invitee = Invitee::whereId($request->invitee_id)->whereBusinessId($business->id)->first();
        if (!$invitee) {
            return $this->sendError('Invitee not found for this business', [], 404);
        }

        // Update Business User record if invitee exists as a user
        $inviteeUser = User::whereEmail($invitee->email)->first();
        if ($request->activity === "disable") {
            $invitee->status = Invitee::$STATUS_DISABLED;
        }
        if ($inviteeUser) {
            $inviteeBusinessUser = BusinessUser::whereUserId($inviteeUser->id)
                ->whereBusinessId($business->id)->first();
            if ($request->activity === "enable") {
                $inviteeBusinessUser->enabled = true;
                $invitee->status = Invitee::$STATUS_ENABLED;
            }
            if ($request->activity === "disable") {
                $inviteeBusinessUser->enabled = false;
                $invitee->status = Invitee::$STATUS_DISABLED;
            }

            $inviteeBusinessUser->save();
            $invitee->save();
        }
        return $this->sendSuccess("Invitee Role updated successfully", [
            "invitee" => $invitee
        ]);
    }

    public function viewInviteDetails(Request $request)
    {
        // return encrypt("935213");
        $request->validate([
            "invitation_token" => "required",
        ]);
        $invitation_token = $request->invitation_token;
        try {
            $code = decrypt($invitation_token);
        } catch (Exception $e) {
            return $this->sendError('Invalid token provided', [], 400);
        }

        $invitee = Invitee::whereCode($code)->first();
        if (!$invitee) {
            return $this->sendError('Invitation Token not found', [], 400);
        }


        if ($invitee->status === 1) {
            return $this->sendError('This invitation has already been accepted and processed', [], 400);
        }

        $business = $invitee->business;

        // Check if user exists
        $user = User::whereEmail($invitee->email)->first();
        $role = Role::find($invitee->role_id);
        $userExists = $user ? true : false;

        return $this->sendSuccess("Invitee details fetched successfully", [
            "invitee" => $invitee,
            "business" => $business,
            "user" => $user,
            "role" => $role,
            "user_exists" => $userExists,
        ]);
    }

    public function acceptInvite(Request $request)
    {
        $request->validate([
            "invitation_token" => "required",
            "email" => "required|email"
        ]);

        $invitation_token = $request->invitation_token;
        try {
            $code = decrypt($invitation_token);
        } catch (Exception $e) {
            return $this->sendError('Invalid token provided', [], 400);
        }

        $invitee = Invitee::whereEmail($request->email)->whereCode($code)->first();
        if (!$invitee) {
            return $this->sendError('Invitation Token not found', [], 400);
        }

        if ($invitee->status === 1) {
            return $this->sendError('This invitation has already been accepted and processed', [], 400);
        }

        $business = $invitee->business;
        $activeBusiness = false;
        // Check if user exists
        $user = User::whereEmail($request->email)->first();
        if (!$user) {
            $activeBusiness = true;
            $request->validate([
                "first_name" => "required|string|max:50",
                "last_name" => "required|string|max:50",
                "email" => "required|string|email|max:100|unique:users,email",
                "password" => "required", Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->rules([new StandardPassword]),
            ]);
            $user = User::create([
                "first_name" => $request->first_name,
                "last_name" => $request->last_name,
                "email" => $request->email,
                "business_id" => $business->id,
                "password" => bcrypt($request->password),
                "password_changed" => true,
            ]);
        }
        $user->businesses()->attach($business->id, ["is_active" => $activeBusiness, "role_id" => $invitee->role_id]);
        $businessUser = BusinessUser::whereBusinessId($business->id)->whereUserId($user->id)->first();
        $role = Role::find($invitee->role_id);
        $businessUser->syncRoles([$role->name]);
        $invitee->status = Invitee::$STATUS_ENABLED;
        $invitee->save();

        // Notifications follow...
        return $this->sendSuccess("Invitation successfully accepted and processed. You can now log into your dashboard");
    }

    public function notifyInvitee($invitee, $business, $inviter, $role, $url = null)
    {
        $mailContent = new GenericMail('email.invitee-notification', [
            "invitee" => $invitee,
            "business" => $business,
            "inviter" => $inviter,
            "role" => $role,
            "url" => $url,
        ], 'payload', 'Invitation mail');
        // if (!env("LOCAL_MAIL_SERVER")) {

        $mail = new MailApiService($invitee->email, "[Vas Reseller] You have been invited to collaborate", $mailContent->render());
        try {
            $mailError = null;
            $mail->send();
        } catch (Exception $e) {
            // $mailError = $e->getMessage();
            throw $e;
        };
        return $mailError;
        // } else {
        //     Mail::to($invitee)->send($mailContent);
        // }
    }

    public function checkAuthorization($user, $business, $permitted_role = "business_super_admin")
    {
        $businessUser = BusinessUser::whereBusinessId($business->id)->whereUserId($user->id)->first();
        // Does this user actually still have this business under them?
        if (!$businessUser) {
            return $this->sendError('We could not find this business for this user.', [], 403)->throwResponse();
        }
        // Is this business the current active business of this user?       
        if (!$businessUser->is_active) {
            return $this->sendError('This is not the current active business of this user. Please update active business first.', [], 403)->throwResponse();
        }
        // Can this user perform this action on this active business?
        $businessUserRole = Role::find($businessUser->role_id);

        if (!($businessUserRole && $businessUserRole->name == $permitted_role)) {
            return $this->sendError('User does not have the role to perform this action on this business', [], 403)->throwResponse();
        }
    }
}
