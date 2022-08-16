<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $guard_name = 'web';

    public static function getAppPermissions()
    {
        return
            collect(
                [
                    [
                        "name" => "business_get_transactions",
                        "readable_name" => "Get Business Transactions",
                        "description" => ""
                    ],
                    [
                        "name" => "business_search_transactions",
                        "readable_name" => "Search Business Transactions",
                        "description" => ""
                    ],
                    [
                        "name" => "business_show_transaction",
                        "readable_name" => "Show Business Transaction Details",
                        "description" => ""
                    ],
                    [
                        "name" => "business_get_stats",
                        "readable_name" => "Get Business Stats",
                        "description" => ""
                    ],
                    [
                        "name" => "business_get_products",
                        "readable_name" => "Get Business Products",
                        "description" => ""
                    ],
                    [
                        "name" => "business_get_products_configurations",
                        "readable_name" => "Get Business Products Configurations",
                        "description" => ""
                    ],
                    [
                        "name" => "business_switch_environment",
                        "readable_name" => "Switch Business Environment",
                        "description" => ""
                    ],
                    [
                        "name" => "business_switch_active_business",
                        "readable_name" => "Switch Active Business",
                        "description" => ""
                    ],
                    [
                        "name" => "business_upload_documents",
                        "readable_name" => "Upload Business Documents",
                        "description" => ""
                    ],
                    [
                        "name" => "business_get_documents",
                        "readable_name" => "Get Business Documents",
                        "description" => ""
                    ],
                    [
                        "name" => "business_validate_bank_account",
                        "readable_name" => "Validate Business Bank Account",
                        "description" => ""
                    ],
                    [
                        "name" => "busness_validate_bank_otp",
                        "readable_name" => "Validate Business Bank Account OTP",
                        "description" => ""
                    ],
                    [
                        "name" => "business_send_invitations",
                        "readable_name" => "Send Invitations",
                        "description" => ""
                    ],
                    [
                        "name" => "business_resend_invitations",
                        "readable_name" => "Resend Invitations",
                        "description" => ""
                    ],
                    [
                        "name" => "business_update_invitee_role",
                        "readable_name" => "Update Role on Invitee",
                        "description" => ""
                    ],
                    [
                        "name" => "business_get_invitations",
                        "readable_name" => "Get Invitations",
                        "description" => ""
                    ],
                    [
                        "name" => "business_update_invitee_activity",
                        "readable_name" => "Enable or Disable Invitee",
                        "description" => ""
                    ],
                    [
                        "name" => "business_get_whitelist_ips",
                        "readable_name" => "Get Whitelist IP Addresses",
                        "description" => ""
                    ],
                    [
                        "name" => "business_set_whitelist_ips",
                        "readable_name" => "Set Whitelist IP Addresses",
                        "description" => ""
                    ],
                    [
                        "name" => "business_toggle_notification",
                        "readable_name" => "Toggle Business Notifications",
                        "description" => ""
                    ],
                    [
                        "name" => "business_reset_keys",
                        "readable_name" => "Reset Business API Keys",
                        "description" => ""
                    ],
                    [
                        "name" => "business_get_low_balance_threshold",
                        "readable_name" => "Get Low Balance Threshold",
                        "description" => ""
                    ],
                    [
                        "name" => "business_set_low_balance_threshold",
                        "readable_name" => "Set Low Balance Threshold",
                        "description" => ""
                    ],
                    [
                        "name" => "business_set_webhook_url",
                        "readable_name" => "Set Webhook URL",
                        "description" => ""
                    ],
                    [
                        "name" => "business_get_webhook_url",
                        "readable_name" => "Get Webhook URL",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_get_stats",
                        "readable_name" => "Get Transaction Stats (Admin)",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_get_products_commissions",
                        "readable_name" => "Get Commissions per Product (Admin)",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_get_businesses",
                        "readable_name" => "Get Businesses (Admin)",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_show_business",
                        "readable_name" => "Show Business Details (Admin)",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_show_business_documents",
                        "readable_name" => "Show Business Documents (Admin)",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_approve_business_documents",
                        "readable_name" => "Approve Business Documents (Admin)",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_get_business_users",
                        "readable_name" => "Get Business Users (Admin)",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_get_business_products",
                        "readable_name" => "Get Business Products (Admin)",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_toggle_live_enabled",
                        "readable_name" => "Toggle a business' ability to go live (Admin)",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_set_merchant_data",
                        "readable_name" => "Set Business Merchant and Terminal IDs (Admin)",
                        "description" => ""
                    ],
                    [
                        "name" => "admin_create_admin",
                        "readable_name" => "Create an admin and assign role (Admin)",
                        "description" => ""
                    ],
                ]
            );
    }


    public static function permissionForRoles()
    {
        return collect([
            [
                "role" => "business_super_admin",
                "permissions" => [
                    "business_get_transactions",
                    "business_search_transactions",
                    "business_show_transaction",
                    "business_get_stats",
                    "business_get_products",
                    "business_get_products_configurations",
                    "business_switch_environment",
                    "business_switch_active_business",
                    "business_upload_documents",
                    "business_get_documents",
                    "business_validate_bank_account",
                    "busness_validate_bank_otp",
                    "business_send_invitations",
                    "business_resend_invitations",
                    "business_update_invitee_role",
                    "business_get_invitations",
                    "business_update_invitee_activity",
                    "business_get_whitelist_ips",
                    "business_set_whitelist_ips",
                    "business_toggle_notification",
                    "business_reset_keys",
                    "business_get_low_balance_threshold",
                    "business_set_low_balance_threshold",
                    "business_set_webhook_url",
                    "business_get_webhook_url",
                ],
            ],
            [
                "role" => "business_finance",
                "permissions" => [
                    "business_get_stats",
                    "business_search_transactions",
                    "business_show_transaction",

                ],
            ],
            [
                "role" => "business_developer",
                "permissions" => [
                    "business_get_stats",
                    "business_get_whitelist_ips",
                    "business_set_whitelist_ips",
                    "business_toggle_notification",
                    "business_get_low_balance_threshold",
                    "business_set_low_balance_threshold",
                    "business_set_webhook_url",
                    "business_get_webhook_url",
                ],
            ],
            [
                "role" => "owner_super_admin",
                "permissions" => [
                    "admin_get_stats",
                    "admin_get_products_commissions",
                    "admin_get_businesses",
                    "admin_show_business",
                    "admin_show_business_documents",
                    "admin_approve_business_documents",
                    "admin_get_business_users",
                    "admin_get_business_products",
                    "admin_toggle_live_enabled",
                    "admin_set_merchant_data",
                    "admin_create_admin",
                ],
            ],
        ]);
    }

    public static function getPermissionsList()
    {
        return [

            "business_get_transactions",
            "business_search_transactions",
            "business_show_transaction",
            "business_get_stats",
            "business_get_products",
            "business_get_products_configurations",
            "business_switch_environment",
            "business_switch_active_business",
            "business_upload_documents",
            "business_get_documents",
            "business_validate_bank_account",
            "busness_validate_bank_otp",
            "business_send_invitations",
            "business_resend_invitations",
            "business_update_invitee_role",
            "business_get_invitations",
            "business_update_invitee_activity",
            "business_reset_keys",

            "business_get_whitelist_ips",
            "business_set_whitelist_ips",
            "business_toggle_notification",
            "business_get_low_balance_threshold",
            "business_set_low_balance_threshold",
            "business_set_webhook_url",
            "business_get_webhook_url",

            "admin_get_stats",
            "admin_get_products_commissions",
            "admin_get_businesses",
            "admin_show_business",
            "admin_show_business_documents",
            "admin_approve_business_documents",
            "admin_get_business_users",
            "admin_get_business_products",
            "admin_toggle_live_enabled",
            "admin_set_merchant_data",
            "admin_create_admin",
        ];
    }
}
