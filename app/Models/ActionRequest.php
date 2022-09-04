<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionRequest extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        "payload" => 'array',
        "handler" => 'array',
        "initial_data" => 'array',
        "final_data" => 'array',
    ];
}
