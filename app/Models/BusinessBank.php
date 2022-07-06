<?php

namespace App\Models;

use App\Models\Business;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessBank extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
