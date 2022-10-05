<?php

namespace App\Models;

use App\Models\Product;
use App\Events\ProductConfigUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            // throw event
            event(new ProductConfigUpdated());
            return;
        });

        static::updated(function ($model) {
            // throw event
            event(new ProductConfigUpdated());
            return;
        });

        static::deleted(function ($model) {
            // throw event
            event(new ProductConfigUpdated());
            return;
        });
    }
}
