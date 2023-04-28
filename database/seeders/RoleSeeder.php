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
                "name" => "list_products_for_business",
                "guard_name" => "web",
                "readable_name" => "List Products under Business dashboard"
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
            [
                "name" => "approve_business_documents",
                "guard_name" => "web",
                "readable_name" => "Approve/Reject Business Documents",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "create_businesses",
                "guard_name" => "web",
                "readable_name" => "Create Businesses",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_request_logs",
                "guard_name" => "web",
                "readable_name" => "View Request Logs",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "toggle_product_enabled",
                "guard_name" => "web",
                "readable_name" => "Toggle product enable on business",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_products",
                "guard_name" => "web",
                "readable_name" => "List Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "edit_products",
                "guard_name" => "web",
                "readable_name" => "Edit products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_billers",
                "guard_name" => "web",
                "readable_name" => "List billers",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "edit_billers",
                "guard_name" => "web",
                "readable_name" => "Edit billers",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_banks",
                "guard_name" => "web",
                "readable_name" => "List banks",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "edit_banks",
                "guard_name" => "web",
                "readable_name" => "Edit banks",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_admins",
                "guard_name" => "web",
                "readable_name" => "List Admin Users",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "create_admin",
                "guard_name" => "web",
                "readable_name" => "Create  Admin",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "manage_roles",
                "guard_name" => "web",
                "readable_name" => "Manage Roles",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_logs",
                "guard_name" => "web",
                "readable_name" => "View Logs",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_business_users",
                "guard_name" => "web",
                "readable_name" => "List business users",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_business_products",
                "guard_name" => "web",
                "readable_name" => "List business products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "enable_product_for_business",
                "guard_name" => "web",
                "readable_name" => "Enable product for business",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_business_documents",
                "guard_name" => "web",
                "readable_name" => "View business documents",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_action_requests",
                "guard_name" => "web",
                "readable_name" => "View Action Requests",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "create_banks",
                "guard_name" => "web",
                "readable_name" => "Create Banks",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_banks",
                "guard_name" => "web",
                "readable_name" => "List Banks",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_banks",
                "guard_name" => "web",
                "readable_name" => "View Banks",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "update_banks",
                "guard_name" => "web",
                "readable_name" => "Update Banks",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "delete_banks",
                "guard_name" => "web",
                "readable_name" => "Delete Banks",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "create_billers",
                "guard_name" => "web",
                "readable_name" => "Create Billers",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_billers",
                "guard_name" => "web",
                "readable_name" => "List Billers",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_billers",
                "guard_name" => "web",
                "readable_name" => "View Billers",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "update_billers",
                "guard_name" => "web",
                "readable_name" => "Update Billers",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "delete_billers",
                "guard_name" => "web",
                "readable_name" => "Delete Billers",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "create_business_categories",
                "guard_name" => "web",
                "readable_name" => "Create Business Categories",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_business_categories",
                "guard_name" => "web",
                "readable_name" => "List Business Categories",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_business_categories",
                "guard_name" => "web",
                "readable_name" => "View Business Categories",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "update_business_categories",
                "guard_name" => "web",
                "readable_name" => "Update Business Categories",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "delete_business_categories",
                "guard_name" => "web",
                "readable_name" => "Delete Business Categories",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "create_product_categories",
                "guard_name" => "web",
                "readable_name" => "Create Product Categories",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_product_categories",
                "guard_name" => "web",
                "readable_name" => "List Product Categories",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_product_categories",
                "guard_name" => "web",
                "readable_name" => "View Product Categories",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "update_product_categories",
                "guard_name" => "web",
                "readable_name" => "Update Product Categories",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "delete_product_categories",
                "guard_name" => "web",
                "readable_name" => "Delete Product Categories",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "create_sub_products",
                "guard_name" => "web",
                "readable_name" => "Create Sub-Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_sub_products",
                "guard_name" => "web",
                "readable_name" => "List Sub-Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_sub_products",
                "guard_name" => "web",
                "readable_name" => "View Sub-Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "update_sub_products",
                "guard_name" => "web",
                "readable_name" => "Update Sub-Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "delete_sub_products",
                "guard_name" => "web",
                "readable_name" => "Delete Sub-Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "create_products",
                "guard_name" => "web",
                "readable_name" => "Create Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "list_products",
                "guard_name" => "web",
                "readable_name" => "List Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_products",
                "guard_name" => "web",
                "readable_name" => "View Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "update_products",
                "guard_name" => "web",
                "readable_name" => "Update Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "delete_products",
                "guard_name" => "web",
                "readable_name" => "Delete Products",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "view_business_product_configuration",
                "guard_name" => "web",
                "readable_name" => "View Product Configuration on Business",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "update_business_product_configuration",
                "guard_name" => "web",
                "readable_name" => "Update Product Configuration on Business",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "delete_business_product",
                "guard_name" => "web",
                "readable_name" => "Delete Business Product",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "add_product_for_business",
                "guard_name" => "web",
                "readable_name" => "Add product for a business",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "add_product_for_businesses",
                "guard_name" => "web",
                "readable_name" => "Add product for businesses",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "remove_product_for_business",
                "guard_name" => "web",
                "readable_name" => "Remove product for business",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "check_approve_business_documents",
                "guard_name" => "web",
                "readable_name" => "Check business document approval",
                "description" => null,
                "is_admin" => true
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
                "name" => "action_checker",
                "guard_name" => "web",
                "readable_name" => "Action Checker",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "document_reviewer",
                "guard_name" => "web",
                "readable_name" => "Document Reviewer",
                "description" => null,
                "is_admin" => true
            ],
            [
                "name" => "product_editor",
                "guard_name" => "web",
                "readable_name" => "Product Editor",
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
            "list_business_transactions",
            "search_business_transactions",
            "show_business_stats",
        ];

        $developer_permissions = [
            "get_whitelist_ips",
            "set_whitelist_ips",
            "get_low_balance_threshold",
            "set_low_balance_threshold",
            "get_webhook_url",
            "set_webhook_url",
            "show_business_stats",
            "list_products_for_business"
        ];

        $action_checker_permissions = [
            'view_business',
            'view_business_documents',
            'view_action_requests',
            'check_approve_business_documents'
        ];

        $document_reviewer_permissions = ["list_businesses", 'view_business', 'list_document_requests', 'view_business_documents', 'approve_business_documents'];
        $product_editor_permissions = [
            "list_products",
            'edit_products',
            'list_business_products',
            'enable_product_for_business',
            'create_products',
            'view_products',
            'delete_products',
            'view_business_product_configuration',
            'update_business_product_configuration',
            'delete_business_product',
            'add_product_for_business',
            'add_product_for_businesses',
            'remove_product_for_business'
        ];


        Role::whereName(sc('BUSINESS_ADMIN_ROLE'))->first()->syncPermissions($permissions->where('is_admin', false)->pluck('name'));
        Role::whereName(sc('BUSINESS_DEVELOPER_ROLE'))->first()->syncPermissions($developer_permissions);
        Role::whereName(sc('BUSINESS_FINANCE_ROLE'))->first()->syncPermissions($finance_permissions);
        Role::whereName('action_checker')->first()->syncPermissions($action_checker_permissions);
        Role::whereName('document_reviewer')->first()->syncPermissions($document_reviewer_permissions);
        Role::whereName('product_editor')->first()->syncPermissions($product_editor_permissions);
        Role::whereName(sc('SUPER_ADMIN_ROLE'))->first()->syncPermissions($permissions->where('is_admin', true)->pluck('name'));
    }


// Sidebar
// [
//     "dashboard" => ["show_business_stats", "view_admin_dashboard"],
//     "transactions" => ["list_business_transactions", "search_business_transactions", "view_transactions"],
//     "documentation" => ["list_business_documents", "approve_business_documents", "list_document_requests"],
//     "settings" => ["get_whitelist_ips", "set_whitelist_ips", "get_low_balance_threshold", "set_low_balance_threshold", "get_webhook_url", "set_webhook_url"],
//     "product" => ["list_products", 'edit_products',],
//     "users" => ["list_invitations", "send_invitations", "list_admins", "manage_roles"],
// "logs" => ["view_request_logs", "view_logs"],
// "request_logs" => ["view_request_logs",  "view_logs"],

// ];
}