<?php

namespace App\Http\Controllers;

use App\Mail\GenericMail;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Invitee;
use App\Models\User;
use App\Rules\StandardPassword;
use App\Services\MailApiService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class InviteeController extends Controller
{
    //

    public function sendInvites(Request $request)
    {

        $request->validate([
            "window_location" => "required|string|url",
            "invitations" => "required|array",
            "invitations.*.email" => "required|email",
            "invitations.*.role_id" => "required|exists:roles,id"
        ]);
        $user = auth()->user();
        $business = $user->business;
        $businessUser = BusinessUser::whereBusinessId($business->id)->whereUserId($user->id)->first();
        // Does this user actually still have this business under them?
        if (!$businessUser) {
            return $this->sendError('We could not find this business for this user.', [], 403);
        }
        // Is this business the current active business of this user?       
        if (!$businessUser->is_active) {
            return $this->sendError('This is not the current active business of this user. Please update active business first.', [], 403);
        }
        // Can this user perform this action on this active business?
        $businessUserRole = Role::find($businessUser->role_id);

        if (!($businessUserRole && $businessUserRole->name == "business_super_admin")) {
            return $this->sendError('User does not have the roles to perform this action on this business', [], 403);
        }
        $window_location = $request->window_location;
        // Good to go.
        $invitees = collect($request->invitations)->map(function ($invitation) use ($business, $user, $window_location) {
            $code = rand(10, 99) . rand(10, 99) . rand(10, 99);
            
            // Don't send to invitor
            if($invitation["email"] == $user->email){
                return;
            }
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

            $mailing = $this->notifyInvitee($invitee, $business, $user, $window_location);

            return $invitee;
        });

        return $this->sendSuccess('Invitations sent successfully');
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

        // Check if user exists
        $user = User::whereEmail($request->email)->first();
        $activeBusiness = !$user;
        if (!$user) {
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
        $invitee->status = 1;
        $invitee->save();
        $user->load('businesses','business.businessBank');
        // Fetch User Roles and Permissions
        $roles = $user->roles->pluck('name')->toArray();
        $permissions = $user->permissions->pluck('name')->toArray();

        // Create API Token for user
        $token =  $user->createToken(config('auth.auth_token_name'))->plainTextToken;

        $data = [
            "user" => $user,
            // "balance" => $balance,
            "access_token" => $token,
            "user_roles" => $roles,
            "user_permissions" => $permissions,
        ];

        // Notifications follow...
        return $this->sendSuccess("Invitation successfully accepted and processed. You are now logged in", $data);

        return $user;
        return $code;
    }

    public function makeInvitation($email, $business_id)
    {
        // $invitee = Invitee::whereEmail($email)->first();
        // return $invitee;
    }

    public function notifyInvitee($invitee, $business, $inviter, $url=null)
    {
        $mailContent = new GenericMail('email.invitee-notification', [
            "invitee" => $invitee,
            "business" => $business,
            "inviter" => $inviter,
            "url" => $url,
        ], 'payload', 'Invitation mail');
        if (!env("LOCAL_MAIL_SERVER")) {

            $mail = new MailApiService($invitee->email, "[Vas Reseller] You have been invited to collaborate", $mailContent->render());
            try {
                $mailError = null;
                $mail->send();
            } catch (Exception $e) {
                $mailError = $e->getMessage();
            };
            return $mailError;
        } else {
            Mail::to($invitee)->send($mailContent);
        }
    }
}
