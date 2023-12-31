<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminActionLog extends Model
{
    protected $guarded = [];
    use HasFactory;
    protected $casts = [
        "request_body" => "array"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
