<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role as ModelsRole;

class RolesUpdatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Remove and reset roles;
        Permission::query()->delete();
        Role::query()->delete();
        // return ;
        $permissions = collect([
            [
                "name" => "switch_business_environment",
                "guard_name" => "web",
                "readable_name" => "Switch Business Environment"
            ],
            [
                "name" => "switch_active_business",
                "guard_name" => "web",
                "readable_name" => "Switch Activr Business"
            ],
            [
                "name" => "upload_business_documents",
                "guard_name" => "web",
                "readable_name" => "Upload Business Documents"
            ],
            [
                "name" => "request_documents_approval",
                "guard_name" => "web",
                "readable_name" => "Request Document Approval"
            ],
            [
                "name" => "list_business_documents",
                "guard_name" => "web",
                "readable_name" => "List Business Documents"
            ],
            [
                "name" => "validate_business_bank_details",
                "guard_name" => "web",
                "readable_name" => "Validate Business Bank Details"
            ],
            [
                "name" => "send_invitations",
                "guard_name" => "web",
                "readable_name" => "Send Invitations"
            ],
            [
                "name" => "resend_invitation",
                "guard_name" => "web",
                "readable_name" => "Resend Invitation"
            ],
            [
                "name" => "list_invitations",
                "guard_name" => "web",
                "readable_name" => "List Invitations"
            ],
            [
                "name" => "set_invitee_role",
                "guard_name" => "web",
                "readable_name" => "Set Invitee Role"
            ],
            [
                "name" => "set_invitee_activity",
                "guard_name" => "web",
                "readable_name" => "Enable or Disable Invitee"
            ],
            [
                "name" => "get_whitelist_ips",
                "guard_name" => "web",
                "readable_name" => "Get Whitelist IPs"
            ],
            [
                "name" => "set_whitelist_ips",
                "guard_name" => "web",
                "readable_name" => "Set Whitelist IPs"
            ],
            [
                "name" => "toggle_notifications",
                "guard_name" => "web",
                "readable_name" => "Toggle Notifications"
            ],
            [
                "name" => "reset_business_keys",
                "guard_name" => "web",
                "readable_name" => "Reset Business Keys"
            ],
            [
                "name" => "get_low_balance_threshold",
                "guard_name" => "web",
                "readable_name" => "Get Low Balance Threshold"
            ],
            [
                "name" => "set_low_balance_threshold",
                "guard_name" => "web",
                "readable_name" => "Set Low Balance Threshold"
            ],
            [
                "name" => "get_webhook_url",
                "guard_name" => "web",
                "readable_name" => "Get Webhook Url"
            ],
            [
                "name" => "set_webhook_url",
                "guard_name" => "web",
                "readable_name" => "Set Webhook Url"
            ],
            [
                "name" => "list_business_transactions",
                "guard_name" => "web",
                "readable_name" => "List Business Transactions"
            ],
            [
                "name" => "search_business_transactions",
                "guard_name" => "web",
                "readable_name" => "Search Business Transactions"
            ],
            [
                "name" => "show_business_stats",
                "guard_name" => "web",
                "readable_name" => "Show Business Statistics"
            ],
        ]);

        $permissions->map(function ($p) {
            Permission::updateOrCreate(
                ["name" => $p["name"]],
                $p
            );
        });
        $roles = collect([
            [
                "name" => "super_admin",
                "guard_name" => "web",
                "readable_name" => "Super Admin Role",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "business_admin",
                "guard_name" => "web",
                "readable_name" => "Business Admin Role",
                "description" => null,
                "is_admin" => false
            ],
            [
                "name" => "business_developer",
                "guard_name" => "web",
                "readable_name" => "Business Developer Role",
                "description" => null,
                "is_admin" => false
            ],
            [
                "name" => "business_finance",
                "guard_name" => "web",
                "readable_name" => "Business Finance Role",
                "description" => null,
                "is_admin" => false
            ],
            [
                "name" => "business_invitee",
                "guard_name" => "web",
                "readable_name" => "Business Invitee Role",
                "description" => null,
                "is_admin" => false
            ],
        ]);

        $roles->map(function ($r) {
            Role::updateOrCreate(
                ["name" => $r["name"]],
                $r
            );
        });

        
        $finance_permissions = [
            "list_business_transactions", "search_business_transactions", "show_business_stats",
        ];
        
        $developer_permissions = [
            "get_whitelist_ips", "set_whitelist_ips", "get_low_balance_threshold", "set_low_balance_threshold", "get_webhook_url", "set_webhook_url", "show_business_stats"
        ];
        ModelsRole::whereName(sc('BUSINESS_ADMIN_ROLE'))->first()->syncPermissions($permissions->pluck('name'));
        ModelsRole::whereName(sc('BUSINESS_DEVELOPER_ROLE'))->first()->syncPermissions($developer_permissions);
        ModelsRole::whereName(sc('BUSINESS_FINANCE_ROLE'))->first()->syncPermissions($finance_permissions);



        $adminBusiness = Business::whereEmail(sc('ADMIN_BUSINESS_EMAIL'))->first();
        $adminUser = User::whereEmail(sc('ADMIN_BUSINESS_EMAIL'))->first();
        $adminBusiness->is_admin = true;
        $adminBusiness->save();
        $adminUser->syncRoles([sc('SUPER_ADMIN_ROLE')]);
    }
}
