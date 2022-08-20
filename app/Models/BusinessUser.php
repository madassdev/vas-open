<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Permission\Traits\HasRoles;

class BusinessUser extends Pivot
{
    //
    use HasRoles;
    protected $guard_name = 'web';

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isPermittedTo($permission)
    {
        $role = $this->role;
        return $role->permissions->where('name',$permission)->first();
    }
}
