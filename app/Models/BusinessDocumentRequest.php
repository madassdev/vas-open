<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDocumentRequest extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function businessDocument()
    {
        return $this->belongsTo(BusinessDocument::class);
    }
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
