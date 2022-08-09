<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'verified',
        'verification_code',
        'business_id',
        'password_changed'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_code'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function businesses()
    {
        return $this->belongsToMany(Business::class);
    }

    public function businessUsers()
    {
        return $this->hasMany(BusinessUser::class);
    }

    public function businessUser()
    {
        return $this->hasOne(BusinessUser::class)->where('is_active', true);
    }

    public function getActiveBusinessAttribute()
    {
        $activeBusiness = BusinessUser::whereUserId($this->id)->whereIsActive(true)->first();
        return $activeBusiness ?? $this->business;
    }
    public function switchActiveBusiness($business_id)
    {
        $businessUser = BusinessUser::whereUserId($this->id)->whereBusinessId($business_id)->first();
        if (!$businessUser) {
            response()->json(["status" => false, "message" => "Business not found for this user", "data" => []], 403)->throwResponse();
        }

        if (!$businessUser->enabled) {
            response()->json(["status" => false, "message" => "This user is not enabled on this business, and cannot switch to this business", "data" => []], 403)->throwResponse();
        }
        // Deactivate all existing records 
        BusinessUser::whereUserId($this->id)->update(['is_active' => false]);

        // Activate this record
        $businessUser->is_active = true;
        $businessUser->save();

        // Update user object to reflect new active business
        $this->business_id = $business_id;
        $this->save();
        return true;
    }

}
