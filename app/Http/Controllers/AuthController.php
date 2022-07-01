<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Mail\PasswordUpdatedMail;
use App\Mail\UserCreatedPasswordMail;
use App\Mail\UserWelcomeMail;
use App\Models\Business;
use App\Models\User;
use App\Rules\StandardPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    //

    public function register(RegistrationRequest $request)
    {
        $generated_password = str()->random(4) . rand(1000, 3000);

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
        // Mail::to($user)->queue(new UserWelcomeMail($user));
        // Mail::to($user)->queue(new UserCreatedPasswordMail($user));
        

        // Create response for test environments where mail may not be setup yet.
        $data = config('app.env') !== 'production' ? ["generated_password" => $generated_password] : [];

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

        // Fetch User Roles and Permissions
        $roles = $user->roles->pluck('name')->toArray();
        $permissions = $user->permissions->pluck('name')->toArray();
        $message = $user->password_changed ? "Login Successful" : "Login successful. | WARNING: Please update your password to continue.";

        $data = [
            "user" => $user,
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
                    ->uncompromised()->rules([new StandardPassword]), 
            ],
            // "new_password" => "required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$/",
        ]);

        return 'pass';

        $user = auth()->user();
        $context = $user->password_changed ? "updated" : "new";
        $user->password = bcrypt($request->new_password);
        $user->password_changed = true;
        $user->save();
        Mail::to($user)->queue(new PasswordUpdatedMail($user, $context));

        return $this->sendSuccess('Password updated successfully', ["context" => $context]);
    }

    public function logout()
    {
        $user = auth()->user();
        $user->tokens()->delete();
        return $this->sendSuccess("User logged out successfully.");
    }
}
