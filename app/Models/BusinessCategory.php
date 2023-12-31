<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }
}
