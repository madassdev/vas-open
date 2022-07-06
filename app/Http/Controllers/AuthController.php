<?php

namespace App\Http\Controllers;

use App\Helpers\DBSwap;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Jobs\UserMailJob;
use App\Mail\GenericMail;
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

    public function generateRandomCharacters($length = 4)
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789!@#$%^&*()'); // and any other characters
        shuffle($seed); // probably optional since array_is randomized; this may be redundant
        $rand = '';
        foreach (array_rand($seed, $length) as $k) $rand .= $seed[$k];
        return $rand;
    }

    public function register(Request $request)
    {

        return $this->sendError('[LIVE ONLY ACTION]: Please register user on live environment only');

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
            "phone" => $request->phone_number,
            "business_id" => $business->id,
            "password" => bcrypt($generated_password),
            "verification_code" => $generated_password,
            "verified" => false,
        ]);

        // Assign role to user 
        $user->assignRole('business_super_admin');
        
        // Create user and business on test env
        
        DBSwap::setConnection('mysqltest');

        $test_business = Business::updateOrCreate([
            "email" => $request->business_email,
        ], [
            "name" => $request->business_name,
            "email" => $request->business_email,
            "phone" => $request->business_phone_number,
            "address" => $request->business_address,
            "current_env" => "test"
        ]);

        // Create User
        $test_user = User::updateOrCreate([
            "email" => $request->email,
        ], [
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "phone" => $request->phone_number,
            "business_id" => $test_business->id,
            "password" => bcrypt($generated_password),
            "verification_code" => $generated_password,
            "verified" => false,
        ]);

        // Assign role to user 
        $test_user->assignRole('business_super_admin');
        

        DBSwap::setConnection('mysqllive');
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
        if (!$user) {
            return $this->sendError("Unauthenticated!", [], 401);
        }
        
        $user = auth()->user()->load('business');
        $balanceService = new BalanceService($user);
        $balance = $balanceService->getBalance($user);
        
        // Fetch User Roles and Permissions
        $roles = $user->roles->pluck('name')->toArray();
        $permissions = $user->permissions->pluck('name')->toArray();
        
        // Create API Token for user
        $token =  $user->createToken(config('auth.auth_token_name'))->plainTextToken;
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
        return $this->sendError('[LIVE ONLY ACTION]: Please update user password on live environment only');
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
        try{

            DBSwap::setConnection('mysqltest');
            $test_user = User::whereEmail($user->email)->first();
            $test_user->password = bcrypt($request->new_password);
            $test_user->password_changed = true;
            $test_user->save();
        }
        catch(Exception $e)
        {
            // Do nothing
        }

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

    public function forgotPassword(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users,email",
        ]);

        $token = $this->generateRandomCharacters(8);
        $user = User::whereEmail($request->email)->firstOrFail();
        $user->verification_code = $token;
        $user->save();

        $mailContent = new GenericMail('email.password-reset-token', $user, 'user');
        $mail = new MailApiService($user->email, "[Vas Reseller] Reset your password", $mailContent->render());

        try {
            $mailError = null;
            $mail->send();
        } catch (Exception $e) {
            $mailError = $e->getMessage();
        };

        // Create response for test environments where mail may not be setup yet.
        $data = config('app.env') !== 'production' ? ["reset_token" => $token, "mail_error" => $mailError] : [];

        return $this->sendSuccess('Password reset request token has been sent. Please check your mail to proceed with requests.', $data);
    }

    public function verifyResetToken(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users,email",
            "token" => "required|exists:users,verification_code"
        ]);

        // Validate token against user
        $user = User::whereEmail($request->email)->firstOrFail();
        if ($user->verification_code !== $request->token) {
            return $this->sendError("[Token mismatch] - The token supplied does not exist for this user!", [], 401);
        }

        return $this->sendSuccess("Token verified successfully. You can now reset your password with this token.", ["token" => $request->token]);
    }

    public function resetPassword(Request $request)
    {
       $request->validate([
            "email" => "required|email|exists:users,email",
            "token" => "required|exists:users,verification_code",
            "new_password" => [
                "required", Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->rules([new StandardPassword]),
            ],
        ]);

        // Validate token against user
        $user = User::whereEmail($request->email)->firstOrFail();
        if ($user->verification_code !== $request->token) {
            return $this->sendError("[Token mismatch] - The token supplied does not exist for this user!", [], 401);
        }

        $user->password = bcrypt($request->new_password);
        $user->verification_code = null;
        $user->password_changed = true;
        $user->save();

        // Should all existing tokens be deleted? 
        // What other security strategies are to be implemented?

        return $this->sendSuccess("Password reset successful, please proceed to login.");


    }
}
