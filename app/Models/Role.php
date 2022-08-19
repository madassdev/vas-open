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
        switch ($this->name) {
            case 'business_developer':
                return $this->readable_name ?? "Business Developer";
                break;
            case 'business_finance':
                return $this->readable_name ?? "Business Finance";
                break;
            case 'business_super_admin':
                return $this->readable_name ?? "Business Administrator";
                break;
            case 'owner_super_admin':
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
        $exemptRoles = ["business_invitee", "business_super_admin", "business_developer", "business_finance"];
    
        $adminableRoles = Role::whereNotIn('name', $exemptRoles)->get();
        return $adminableRoles;
    }
}
