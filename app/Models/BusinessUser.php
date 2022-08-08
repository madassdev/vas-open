<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\Permission\Traits\HasRoles;

class BusinessUser extends Pivot
{
    //
    use HasRoles;
    protected $guard_name = 'web';

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
