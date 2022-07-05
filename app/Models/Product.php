<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_products');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    

    // $items[array_rand($items)]
}
