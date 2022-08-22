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
use App\Models\BusinessUser;
use App\Models\Role as ModelsRole;
use App\Models\User;
use App\Rules\StandardPassword;
use App\Services\BalanceService;
use App\Services\MailApiService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

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

    public function register(RegistrationRequest $request)
    {
        // Setup keys and passwords
        $generated_password = $this->generateRandomCharacters() . $this->generateRandomCharacters();
        // Create business
        $business = Business::updateOrCreate([
            "email" => $request->business_email,
        ], [
            "name" => $request->business_name,
            "email" => $request->business_email,
            "phone" => $request->business_phone_number,
            "address" => $request->business_address,
            "current_env" => "test",
            "live_enabled" => true,
            "business_category_id" => $request->business_category_id,
        ]);

        $business->createWallet();
        $business->test_api_key = strtoupper("pk_test_" . str()->uuid());
        $business->live_api_key = strtoupper("pk_live_" . str()->uuid());
        $business->test_secret_key = strtoupper("sk_test_" . str()->uuid());
        $business->live_secret_key = strtoupper("sk_live_" . str()->uuid());
        $business->save();
        // Create User
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

        // Attach business to user
        $role = ModelsRole::whereName(sc('BUSINESS_ADMIN_ROLE'))->first();
        $user->businesses()->attach($business->id, ["is_active" => true, 'role_id' => $role->id]);

        // Assign role to user 
        $businessUser = BusinessUser::whereBusinessId($business->id)->whereUserId($user->id)->first();
        $businessUser->assignRole($role->name);

        // Create user and business on test env
        DBSwap::setConnection('mysqltest');

        $test_business = Business::updateOrCreate([
            "email" => $request->business_email,
        ], [
            "name" => $request->business_name,
            "email" => $request->business_email,
            "phone" => $request->business_phone_number,
            "address" => $request->business_address,
            "current_env" => "test",
            "test_api_key" => $business->test_api_key,
            "live_enabled" => true,
            "business_category_id" => $request->business_category_id,
        ]);
        $test_business->createWallet();
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

        $test_role = ModelsRole::whereName(sc('BUSINESS_ADMIN_ROLE'))->first();
        // Attach business to user
        $test_user->businesses()->attach($test_business->id, ["is_active" => true, "role_id" => $test_role->id]);

        // Assign role to user 
        $testBusinessUser = BusinessUser::whereBusinessId($test_business->id)->whereUserId($test_user->id)->first();
        $testBusinessUser->assignRole($test_role->name);


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
        $data = [];

        return $this->sendSuccess('User created successfully. Please check your mail for password to proceed with requests.', $data);
    }

    public function login(LoginRequest $request)
    {
        // Verify user credentials
        auth()->attempt($request->only(['email', 'password']));
        $user = auth()->user();
        if (!$user) {
            return $this->sendError("Invalid email or password", [], 401);
        }

        $user->load('businesses', 'business.businessBank', 'businessUser');
        // $balanceService = new BalanceService($user);
        // $balance = $balanceService->getBalance($user);

        // Fetch User Roles and Permissions

        // Create API Token for user
        $token =  $user->createToken(config('auth.auth_token_name'))->plainTextToken;
        $message = $user->password_changed ? "Login Successful" : "Login successful. | WARNING: Please update your password to continue.";
        if ($user->business->is_admin) {
            $role = $user->roles->first();
        } else {
            $role = Role::find($user->active_business->role_id);
        }
        $user->unsetRelation('roles');
        $user->role = $role->load('permissions');
        $user->is_admin = (bool)$user->business->is_admin;
        $data = [
            "access_token" => $token,
            "user" => $user,
            "role" => $role,
            "is_admin" => (bool)$user->business->is_admin
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
        try {

            DBSwap::setConnection('mysqltest');
            $test_user = User::whereEmail($user->email)->first();
            $test_user->password = bcrypt($request->new_password);
            $test_user->password_changed = true;
            $test_user->save();
        } catch (Exception $e) {
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

        $token = rand(10, 99) . rand(10, 99) . rand(10, 99);
        $user = User::whereEmail($request->email)->firstOrFail();
        $user->verification_code = $token;
        $user->save();
        $url = $request->window_location;
        $user->url = $url;
        $mailContent = new GenericMail('email.password-reset-token', $user, 'user');
        // return $mailContent
        $mail = new MailApiService($user->email, "[Vas Reseller] Reset your password", $mailContent->render());

        try {
            $mailError = null;
            $mail->send();
        } catch (Exception $e) {
            $mailError = $e->getMessage();
        };

        // Create response for test environments where mail may not be setup yet.
        // $data = config('app.env') !== 'production' ? ["reset_token" => $token, "mail_error" => $mailError] : [];

        return $this->sendSuccess('Password reset request token has been sent. Please check your mail to proceed with requests.', []);
    }

    public function verifyResetToken(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users,email",
            "token" => "required|string"
        ]);
        try {
            $token = decrypt($request->token);
        } catch (Exception $e) {
            return $this->sendError('Invalid token provided', [], 400);
        }
        // Validate token against user
        $user = User::whereEmail($request->email)->firstOrFail();
        if ($user->verification_code !== $token) {
            return $this->sendError("[Token mismatch] - The token supplied does not exist for this user!", [], 401);
        }

        return $this->sendSuccess("Token verified successfully. You can now reset your password with this token.", ["token" => $request->token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            "token" => "required|string",
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
        try {
            $token = decrypt($request->token);
        } catch (Exception $e) {
            return $this->sendError('Invalid token provided', [], 400);
        }
        $user = User::whereVerificationCode($token)->firstOrFail();
        // if ($user->verification_code !== $token) {
        //     return $this->sendError("[Token mismatch] - The token supplied does not exist for this user!", [], 401);
        // }

        $user->password = bcrypt($request->new_password);
        $user->verification_code = null;
        $user->password_changed = true;
        $user->save();

        // Should all existing tokens be deleted? 
        // What other security strategies are to be implemented?

        return $this->sendSuccess("Password reset successful, please proceed to login.");
    }

    public function me()
    {
        $user = auth()->user();
        $user->load('business.businessBank', 'businesses', 'businessUser');
        if ($user->business->is_admin) {
            $role = $user->roles->first();
        } else {
            $role = Role::find($user->active_business->role_id);
        }
        return $this->sendSuccess('User details fethched successfully', [
            "user" => $user,
            "role" => $role,
            "is_admin" => (bool)$user->business->is_admin
        ]);
    }

    public function roles()
    {
        $protectedRoleNames = [sc("SUPER_ADMIN_ROLE"), sc("INVITEE_ROLE")];
        $roles = ModelsRole::whereNotIn('name', $protectedRoleNames)->get();
        return $this->sendSuccess("Roles fetched successfully", [
            "roles" => $roles
        ]);
    }
}
