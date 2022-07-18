<?php

namespace App\Models;

use App\Models\Business;
use App\Models\WalletLog;
use App\Models\WalletSplit;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function splits()
    {
        return $this->hasMany(WalletSplit::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function logs()
    {
        return $this->hasMany(WalletLog::class);
    }
}
