<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $appends = [
        "title"
    ];
    protected $guard_name = 'web';


    public function getTitleAttribute()
    {
        switch ($this->name) {
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

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'role_has_permissions');
    }
}
