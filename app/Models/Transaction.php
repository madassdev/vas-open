<?php

namespace App\Models;

use App\Models\Business;
use App\Models\TransactionExtra;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function extra()
    {
        return $this->hasOne(TransactionExtra::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    const exportColumns = [
        'id',
        'business_id',
        'business_name',
        'product_id',
        'product_name',
        'product_category_name',
    ];
}
