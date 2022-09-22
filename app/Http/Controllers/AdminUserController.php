<?php

namespace App\Http\Controllers;

use App\Helpers\DBSwap;
use App\Mail\GenericMail;
use App\Models\Business;
use App\Models\BusinessUser;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\MailApiService;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role as SpatieRole;

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
            // "admin_business_email" => "email"
        ]);
        $adminBusiness = Business::whereEmail(sc('ADMIN_BUSINESS_EMAIL'))->orWhere('email', $request->admin_business_email)->first();
        if (!$adminBusiness) {
            sr("Admin business not found, please set valid admin_business_email", [], 404);
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
            "role" => $adminRole->title,
            "password" => $generated_password,
        ], 'payload', 'Admin User mail');

        $mail = new MailApiService($user->email, "[Vas Reseller] Here's your Administrator account details", $mailContent->render());
        try {
            $mailError = null;
            $mail->send();
        } catch (Exception $e) {
            $mailError = $e->getMessage();
        };

        return $this->sendSuccess('User created successfully. Please check your mail for password to proceed with requests.', [
            "user" => $user,
            "role" => $adminRole,
        ]);
    }

    public function getAdmins()
    {
        $this->authorizeAdmin('admin_create_admin');
        $user = auth()->user();
        $adminBusiness = Business::whereEmail(sc('ADMIN_BUSINESS_EMAIL'))->first();
        if (!$adminBusiness) {
            $this->sendError('Admin Business not found.', [], 404);
        }
        return $this->sendSuccess("Admin users fetched successfully", ["admin_users" => $adminBusiness->users]);
    }

    public function getRoles()
    {
        $this->authorizeAdmin('admin_create_admin');
        $roles = Role::adminRoles()->load('permissions');
        $permissions = Permission::whereIsAdmin(false)->get();
        return $this->sendSuccess("Roles and Permissions fetched successfully", [
            "roles" => $roles,
            "permissions" => $permissions,
        ]);
    }

    public function assignAdminRole(Request $request)
    {
        $this->authorizeAdmin('admin_assign_role');
        $request->validate([
            "user_id" => "required|exists:users,id",
            "roles" => "required|array",
            'roles.*' => "required|exists:roles,id"
        ]);

        // Can role be assigned to admin?
        // $role_name = str()->snake($request->role);
        // $adminableRoles = Role::adminRoles();

        // $role = Role::whereName($request->role)
        //     ->orWhere('readable_name', $request->role)
        //     ->orWhere('name', $role_name)
        //     ->orWhere('readable_name', $role_name)
        //     ->first();

        // if (!$role) {
        //     return $this->sendError("The role does not exist: [" . $role_name . "]", [], 404);
        // }

        // if (!$adminableRoles->where('name', $role->name)->first()) {
        //     return $this->sendError("Non admin role cannot be assigned: [" . $role_name . "]", [], 404);
        // }

        // Can user be assigned an admin role?
        $adminBusiness = Business::whereEmail(sc('ADMIN_BUSINESS_EMAIL'))->first();
        if (!$adminBusiness) {
            $this->sendError('Admin Business not found.', [], 404);
        }

        $user = $adminBusiness->users->find($request->user_id);
        if (!$user) {
            return $this->sendError("Admin role cannot be assigned to non admin user", [], 404);
        }

        $roles = collect($request->roles)->map(function ($id) {
            $r = Role::whereIsAdmin(true)->whereId($id)->first();
            if ($r) {
                return $r;
            }
        })->filter()->flatten()->pluck('id');
        // return $roles;

        $user->syncRoles($roles);
        return $this->sendSuccess("Role assigned to admin successsfully", [
            "admin" => $user
        ]);
    }

    public function createRole(Request $request)
    {
        $this->authorizeAdmin('admin_create_admin');
        $request->validate([
            "name" => "required|string",
            "description" => "string|max:500",
            "permissions" => "required|array",
            "permissions.*" => "required|exists:permissions,name",
            "is_admin" => "required|boolean",
        ]);

        $role_name = str()->snake($request->name);
        $role = SpatieRole::whereName($request->name)
            ->orWhere('readable_name', $request->name)
            ->orWhere('name', $role_name)
            ->orWhere('readable_name', $role_name)
            ->first();

        if ($role) {
            return $this->sendError("The role already exists: [" . $role_name . "]", [], 403);
        }

        $role = SpatieRole::create([
            "name" => $role_name,
            "readable_name" => ucfirst($request->name),
            "description" => $request->description,
            "guard_name" => "web",
            "is_admin" => $request->is_admin,
        ]);

        $role->syncPermissions($request->permissions);

        return $this->sendSuccess("Role created successfully", [
            "role" => $role->load('permissions')
        ]);
    }

    public function updateRole(Request $request, SpatieRole $role)
    {
        $this->authorizeAdmin('admin_create_admin');
        $request->validate([
            "name" => "required|string",
            "description" => "string|max:500",
            "permissions" => "required|array",
            "permissions.*" => "required|exists:permissions,name",
            "is_admin" => "required|boolean",
        ]);

        $role_name = str()->snake($request->name);
        $role = SpatieRole::whereName($request->name)
            ->orWhere('readable_name', $request->name)
            ->orWhere('name', $role_name)
            ->orWhere('readable_name', $role_name)
            ->first();

        if (!$role) {
            return $this->sendError(
                "The role does not exist: [" . $role_name . "]",
                [],
                404
            );
        }

        $role->update([
            "name" => $role_name,
            "readable_name" => ucfirst($request->name),
            "description" => $request->description,
            "guard_name" => "web",
            "is_admin" => $request->is_admin,
        ]);

        $role->syncPermissions($request->permissions);

        return $this->sendSuccess("Role updated successfully", [
            "role" => $role->load('permissions')
        ]);
    }

    public function deleteRole(Request $request, SpatieRole $role)
    {
        $this->authorizeAdmin('admin_create_admin');
        $role->delete();
        return $this->sendSuccess("Role deleted successfully", []);
    }

    public function setPermissions(Request $request)
    {
        $this->authorizeAdmin('admin_create_admin');
        $request->validate([
            "role" => "required",
            "permissions" => "required|array",
            "permissions.*" => "required|exists:permissions,name"
        ]);

        $role_name = str()->snake($request->role);
        $role = SpatieRole::whereName($request->role)
            ->orWhere('readable_name', $request->role)
            ->orWhere('name', $role_name)
            ->orWhere('readable_name', $role_name)
            ->first();


        if (!$role) {
            return $this->sendError("The role does not exist: [" . $role_name . "]", [], 404);
        }

        $role->syncPermissions($request->permissions);

        return $this->sendSuccess("Role permissions set successfully", [
            "role" => $role->load('permissions')
        ]);
    }
}
