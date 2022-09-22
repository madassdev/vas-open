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
            $model->shortname = $model->shortname ?? Str::slug($model->name);
        });
    }
}
