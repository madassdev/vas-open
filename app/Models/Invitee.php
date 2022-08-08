<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Invitee extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    protected $hidden = ["code"];
    protected $appends = ["readable_status"];
    public static $STATUS_PENDING = 0;
    public static $STATUS_ENABLED = 1;
    public static $STATUS_DISABLED = 2;

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getReadableStatusAttribute()
    {
        $mappings = [
            "pending", "accepted", "disabled"
        ];

        return @$mappings[$this->status] ?? "unknown";
    }
}
