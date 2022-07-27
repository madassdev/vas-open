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



    // $items[array_rand($items)]
}
