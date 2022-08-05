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
        $role = ModelsRole::whereName('business_super_admin')->first();
        $user->businesses()->attach($business->id, ["is_active" => true, 'role_id' => $role->id]);

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

        $test_role = ModelsRole::whereName('business_super_admin')->first();
        // Attach business to user
        $test_user->businesses()->attach($test_business->id, ["is_active" => true, "role_id" => $test_role->id]);

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
        $user = auth()->user();
        if (!$user) {
            return $this->sendError("Invalid email or password", [], 401);
        }

        $user->load('businesses', 'business.businessBank', 'businessUser');
        $balanceService = new BalanceService($user);
        // $balance = $balanceService->getBalance($user);

        // Fetch User Roles and Permissions
        $roles = $user->roles->pluck('name')->toArray();
        $permissions = $user->permissions->pluck('name')->toArray();

        // Create API Token for user
        // $token =  "pp";
        $token =  $user->createToken(config('auth.auth_token_name'))->plainTextToken;
        $message = $user->password_changed ? "Login Successful" : "Login successful. | WARNING: Please update your password to continue.";
        $user->active_business_role = $user->businessUser->role;
        $data = [
            "user" => $user,
            // "balance" => $balance,
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

        $mailContent = new GenericMail('email.password-reset-token', $user, 'user');
        return $mailContent;
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

    public function me()
    {
        $user = auth()->user();
        $user->load('business.businessBank', 'businesses', 'roles', 'businessUser');
        $user->active_business_role = $user->businessUser->role;
        return $this->sendSuccess('User details fethched successfully', [
            "user" => $user
        ]);
    }

    public function roles()
    {
        $protectedRoleNames = ["owner_super_admin", "business_invitee"];
        $validroles = DB::table('roles')->whereNotIn('name', $protectedRoleNames)->get();
        $roles = $validroles->map(function ($r) {
            $r->title = $this->readableRoleName($r->name);
            return $r;
        });
        return $this->sendSuccess("Roles fetched successfully", [
            "roles" => $roles
        ]);
    }

    public function readableRoleName($name)
    {
        switch ($name) {
            case 'business_developer':
                return "Developer";
                break;
            case 'business_finance':
                return "Finance";
                break;
            case 'business_super_admin':
                return "Administrator";
                break;

            default:
                # code...
                break;
        }
    }
}
