<?php

namespace App\Models;

use App\Models\Biller;
use App\Models\Business;
use App\Models\SubProduct;
use App\Models\Transaction;
use App\Models\ProductCategory;
use App\Events\ProductConfigUpdated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        "fee_configuration" => "array",
        "has_validation" => "boolean",
        "enabled" => "boolean",
        "service_status" => "boolean",
        "deployed" => "boolean",
        "has_fee" => "boolean",
        "has_sub_product" => "boolean",
    ];

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_products');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function biller()
    {
        return $this->belongsTo(Biller::class);
    }

    public function createConfigDto()
    {
        $p = $this;
        $custom_commission = $p->pivot->commission_value;
        $p->category_name = $this->productCategory->name;
        $p->configurations = [
            [
                "type" => "provider_commission_value",
                "name" => "Provide Commission Value",
                "description" => "This is the commission you earn on this product",
                "value" => $custom_commission ? $custom_commission : $p->provider_commission_value
            ],
            [
                "type" => "provider_commission_cap",
                "name" => "Provide Commission Cap",
                "description" => "This is the commission limit on this product",
                "value" => $p->provider_commission_cap
            ],
            [
                "type" => "provider_commission_amount_cap",
                "name" => "Provide Commission Amount Cap",
                "description" => "This is the commission amount limit on this product",
                "value" => $p->provider_commission_cap
            ],
        ];

        return $p;
    }

    public function subProducts()
    {
        return $this->hasMany(SubProduct::class);
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


    // $items[array_rand($items)]
}
