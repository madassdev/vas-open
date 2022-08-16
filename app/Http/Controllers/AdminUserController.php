<?php

namespace App\Http\Controllers;

use App\Helpers\DBSwap;
use App\Mail\GenericMail;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Role;
use App\Models\User;
use App\Services\MailApiService;
use Exception;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    //

    public function addAdmin(Request $request)
    {
        $this->authorizeAdmin('admin_create_admin');
        $user = auth()->user();
        $request->validate([
            "first_name" => "required|string|max:50",
            "last_name" => "required|string|max:50",
            "email" => "required|string|email|max:100|unique:users,email",
            "phone_number" => "required|string|max:50",
            "role_name" => "required|exists:roles,name",
            "admin_business_email" => "email"
        ]);
        $adminBusiness = Business::whereEmail(sc('ADMIN_BUSINsESS_EMAIL'))->orWhere('email', $request->admin_business_email)->first();
        if (!$adminBusiness) {
            sr("Admin business not found, please set valid admin_business_email");
        }

        $generated_password = generateRandomCharacters() . generateRandomCharacters();

        $user = User::updateOrCreate([
            "email" => $request->email,
        ], [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "phone" => $request->phone,
            "business_id" => $adminBusiness->id,
            "password" => bcrypt($generated_password),
            "verified" => false,
            "password_changed" => false,
        ]);
        $businessRole = Role::whereName(sc('BUSINESS_ADMIN_ROLE'))->first();
        $adminRole = Role::whereName($request->role_name)->first();
        $user->businesses()->attach($adminBusiness->id, ["is_active" => true, 'role_id' => $businessRole->id]);

        // Assign role to user 
        $businessUser = BusinessUser::whereBusinessId($adminBusiness->id)->whereUserId($user->id)->first();
        $user->assignRole($adminRole->name);
        $businessUser->assignRole($businessRole->name);

        // Notify user
        $mailError = null;

        $mailContent = new GenericMail('email.admin-user-created', [
            "user" => $user,
            "role" => $adminRole,
            "password" => $generated_password,
        ], 'payload', 'Admin User mail');

        $mail = new MailApiService($user->email, "[Vas Reseller] Here's your Administrator account details", $mailContent->render());
        try {
            $mailError = null;
            $mail->send();
        } catch (Exception $e) {
            $mailError = $e->getMessage();
        };

        // Create response for test environments where mail may not be setup yet.
        $data = config('app.env') !== 'production' ? ["generated_password" => $generated_password, "mail_error" => $mailError] : [];

        return $this->sendSuccess('User created successfully. Please check your mail for password to proceed with requests.', $data);
    }
}
