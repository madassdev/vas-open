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

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
