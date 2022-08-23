<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = [
        "title"
    ];
    protected $guard_name = 'web';


    public function getTitleAttribute()
    {

        return str_replace(" Role", '', $this->role->readable_name);
        switch ($this->name) {
            case sc('BUSINESS_DEVELOPER_ROLE'):
                return $this->readable_name ?? "Business Developer";
                break;
            case sc('BUSINESS_FINANCE_ROLE'):
                return $this->readable_name ?? "Business Finance";
                break;
            case sc('BUSINESS_ADMIN_ROLE'):
                return $this->readable_name ?? "Business Administrator";
                break;
            case sc('SUPER_ADMIN_ROLE'):
                return $this->readable_name ?? "Super Administrator";
                break;

            default:
                # code...
                break;
        }
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public static function adminRoles()
    {
        $exemptRoles = [sc("BUSINESS_INVITEE_ROLE"), sc("BUSINESS_ADMIN_ROLE"), sc("BUSINESS_DEVELOPER_ROLE"), sc("BUSINESS_FINANCE_ROLE")];
    
        $adminableRoles = Role::whereNotIn('name', $exemptRoles)->get();
        return $adminableRoles;
    }
}
