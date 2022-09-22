<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $permissions = collect([
            [
                "name" => "switch_business_environment",
                "guard_name" => "web",
                "readable_name" => "Switch Business Environment"
            ],
            [
                "name" => "switch_active_business",
                "guard_name" => "web",
                "readable_name" => "Switch Active Business"
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

            // ADMIN

            [
                "name" => "view_admin_dashboard",
                "guard_name" => "web",
                "readable_name" => "View Dashboard data as Admin",
                "is_admin" => true,
            ],
            [
                "name" => "list_businesses",
                "guard_name" => "web",
                "readable_name" => "View List of Businesses",
                "is_admin" => true,
            ],
            [
                "name" => "view_business",
                "guard_name" => "web",
                "readable_name" => "Veiw a Business details",
                "is_admin" => true,
            ],
            [
                "name" => "toggle_golive",
                "guard_name" => "web",
                "readable_name" => "Enable/Disable Business going live",
                "is_admin" => true,
            ],
            [
                "name" => "toggle_business_status",
                "guard_name" => "web",
                "readable_name" => "Enable/Disable Business activity",
                "is_admin" => true,
            ],
            [
                "name" => "configure_terminal",
                "guard_name" => "web",
                "readable_name" => "Configure Business terminal details as Admin",
                "is_admin" => true,
            ],
            [
                "name" => "create_business_user",
                "guard_name" => "web",
                "readable_name" => "Create a Business User as Admin",
                "is_admin" => true,
            ],
            [
                "name" => "invite_business_user",
                "guard_name" => "web",
                "readable_name" => "Send Business Invites as Admin",
                "is_admin" => true,
            ],
            [
                "name" => "list_document_requests",
                "guard_name" => "web",
                "readable_name" => "List Business Documents requests as Admin",
                "is_admin" => true,
            ],
            [
                "name" => "view_transactions",
                "guard_name" => "web",
                "readable_name" => "View Transactions data as Admin",
                "is_admin" => true,
            ],
            [
                "name" => "requery_transactions",
                "guard_name" => "web",
                "readable_name" => "Requery Transaction as Admin",
                "is_admin" => true,
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
                "readable_name" => "Super Admin",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "business_admin",
                "guard_name" => "web",
                "readable_name" => "Business Admin",
                "description" => null,
                "is_admin" => false
            ],
            [
                "name" => "business_developer",
                "guard_name" => "web",
                "readable_name" => "Business Developer",
                "description" => null,
                "is_admin" => false
            ],
            [
                "name" => "business_finance",
                "guard_name" => "web",
                "readable_name" => "Business Finance",
                "description" => null,
                "is_admin" => false
            ],
            // [
            //     "name" => "business_invitee",
            //     "guard_name" => "web",
            //     "readable_name" => "Business Invitee",
            //     "description" => null,
            //     "is_admin" => false
            // ],
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
        Role::whereName(sc('BUSINESS_ADMIN_ROLE'))->first()->syncPermissions($permissions->pluck('name'));
        Role::whereName(sc('BUSINESS_DEVELOPER_ROLE'))->first()->syncPermissions($developer_permissions);
        Role::whereName(sc('BUSINESS_FINANCE_ROLE'))->first()->syncPermissions($finance_permissions);
        Role::whereName(sc('SUPER_ADMIN_ROLE'))->first()->syncPermissions($permissions->where('is_admin', true)->pluck('name'));
    }
}
