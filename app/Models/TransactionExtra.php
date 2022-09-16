<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionExtra extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [
        "id",
        "business_headers",
        "transaction_id"
    ];
    

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
