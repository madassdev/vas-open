<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    //

    public function addAdmin(Request $request)
    {
        // $this->authorizeAdmin('admin_create_admin');
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
        return $generated_password;

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
            "password_changed" => true,
        ]);
        $businessRole = Role::whereName('business_super_admin')->first();
        $adminRole = Role::whereName($request->role_name)->first();
        $user->businesses()->attach($adminBusiness->id, ["is_active" => true, 'role_id' => $businessRole->id]);

        // Assign role to user 
        $businessUser = BusinessUser::whereBusinessId($adminBusiness->id)->whereUserId($user->id)->first();
        $user->assignRole('business_super_admin');
        $user->assignRole($request->role_name);
        $businessUser->assignRole('business_super_admin');

        return $user;

        return 123;
    }
}
