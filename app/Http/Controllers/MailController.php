<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Mail\GenericMail;
use App\Mail\UserCreatedPasswordMail;
use App\Models\Business;
use App\Models\Role;
use App\Models\User;
use App\Services\MailApiService;
use Illuminate\Http\Request;

class MailController extends Controller
{
    //
    public function resendAdminCreateUser(Request $request, User $user)
    {
        $this->authorizeAdmin('admin_create_admin');
        $request->validate([
            'role_name' => 'required|exists:roles,name'
        ]);

        if (!$user->resend_mail) {
            return $this->sendError("User already received mail and activated account", [], 403);
        }
        $adminRole = Role::whereName($request->role_name)->first();
        $generated_password = generateRandomCharacters() . generateRandomCharacters();
        $user->password = bcrypt($generated_password);
        $user->save();

        $mailContent = new GenericMail('email.admin-user-created', [
            "user" => $user,
            "role" => $adminRole->title,
            "password" => $generated_password,
        ], 'payload', 'Admin User mail');

        $mail = new MailApiService($user->email, "[Vas Reseller] Here's your Administrator account details", $mailContent->render());
        SendEmailJob::dispatch($mail);
        return $this->sendSuccess("Admin User Mail resent successfully!");
    }

    public function resendAdminCreateBusiness(Request $request, Business $business)
    {
        $this->authorizeAdmin('admin_create_business');
        if (!$business->resend_mail) {
            return $this->sendError("Business already received mail and activated account", [], 403);
        }
        $business = Business::find($request->business_id);
        $user = $business->user;
        $passwordMail = new MailApiService($user->email, "[Vas Reseller] Here's your account details!", (new UserCreatedPasswordMail($user))->render());
        SendEmailJob::dispatch($passwordMail);
        return $this->sendSuccess("Business Registration Mail resent successfully!");
    }
}
