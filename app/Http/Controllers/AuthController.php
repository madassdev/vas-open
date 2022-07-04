<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Jobs\UserMailJob;
use App\Mail\PasswordUpdatedMail;
use App\Mail\UserCreatedPasswordMail;
use App\Mail\UserWelcomeMail;
use App\Models\Business;
use App\Models\User;
use App\Rules\StandardPassword;
use App\Services\BalanceService;
use App\Services\MailApiService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    //

    public function generateRandomCharacters()
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789!@#$%^&*()'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $rand = '';
        foreach (array_rand($seed, 4) as $k) $rand .= $seed[$k];
        return $rand;
    }

    public function register(RegistrationRequest $request)
    {

        // Create business
        $business = Business::updateOrCreate([
            "email" => $request->business_email,
        ], [
            "name" => $request->business_name,
            "email" => $request->business_email,
            "phone" => $request->business_phone_number,
            "address" => $request->business_address,
            "current_env" => "test"
        ]);

        // Create User
        $generated_password = $this->generateRandomCharacters() . $this->generateRandomCharacters();
        $user = User::updateOrCreate([
            "email" => $request->email,
        ], [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "business_id" => $business->id,
            "password" => bcrypt($generated_password),
            "verification_code" => $generated_password,
            "verified" => false,
        ]);

        // Assign role to user 
        $user->assignRole('business_super_admin');


        // TODO: Create user on test env

        // Notify user
        $mailError = null;
        $passwordMail = new MailApiService($user->email, "[Vas Reseller] Here's your account details!", (new UserCreatedPasswordMail($user))->render());
        try {
            $passwordMail->send();
        } catch (Exception $e) {
            $mailError = $e->getMessage();
        };

        // Create response for test environments where mail may not be setup yet.
        $data = config('app.env') !== 'production' ? ["generated_password" => $generated_password, "mail_error" => $mailError] : [];

        return $this->sendSuccess('User created successfully. Please check your mail for password to proceed with requests.', $data);
    }

    public function login(LoginRequest $request)
    {
        // Verify user credentials
        auth()->attempt($request->only(['email', 'password']));
        $user = auth()->user();
        if (!$user) {
            return $this->sendError("Unauthenticated!", [], 401);
        }

        // Create API Token for user
        $token =  $user->createToken(config('auth.auth_token_name'))->plainTextToken;

        // 
        $balance = BalanceService::getBalance($user);
        // return $balance;

        // Fetch User Roles and Permissions
        $roles = $user->roles->pluck('name')->toArray();
        $permissions = $user->permissions->pluck('name')->toArray();
        $message = $user->password_changed ? "Login Successful" : "Login successful. | WARNING: Please update your password to continue.";


        $data = [
            "user" => $user,
            "balance" => $balance,
            "access_token" => $token,
            "user_roles" => $roles,
            "user_permissions" => $permissions,
        ];
        return $this->sendSuccess($message, $data);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            "password" => "required|current_password",
            "new_password" => [
                "required", Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->rules([new StandardPassword]),
            ],
            // "new_password" => "required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$/",
        ]);

        // return 'pass';

        $user = auth()->user();
        $context = $user->password_changed ? "updated" : "new";
        $user->password = bcrypt($request->new_password);
        $user->password_changed = true;
        $user->save();

        $passwordUpdatedMail = new MailApiService($user->email, "[Vas Reseller] Password updated successfully!", (new PasswordUpdatedMail($user, $context))->render());
        $mailError = null;
        try {
            $passwordUpdatedMail->send();
        } catch (Exception $e) {
            $mailError = $e->getMessage();
        };


        return $this->sendSuccess('Password updated successfully', ["context" => $context, "mail_error" => $mailError]);
    }

    public function logout()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return $this->sendSuccess("User logged out successfully.");
    }
}
