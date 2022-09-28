<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubProduct extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function product ()
    {
        return $this->belongsTo(Product::class);
    }

    static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // $model_has_shortname = 
            if($model->shortname == null) {
                $parent = $model->product;
                $model->shortname = Str::slug($parent->name . '-' . $model->name);
            }
            return;
        });
    }
}
