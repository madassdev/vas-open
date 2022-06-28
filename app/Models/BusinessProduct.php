<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function businesses()
    {
        return $this->belongsToMany(Business::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }    

    public function walletLogs()
    {
        return $this->hasMany(WalletLog::class);
    }
}
