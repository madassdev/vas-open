<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_products');
    }
    use HasFactory;
}
