<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDocument extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = [
        "documents_count"
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function getDocumentsCountAttribute()
    {
        $count = 0;
        // $has_doc = $documents->
        $fields = [
            "cac_2",
            "cac_7",
            "certificate",
            "company_profile",
            "board_resolution",
            "memo_article",
            "share_allotment",
            "director_1",
            "director_2",
            "director_3",
        ];
       
        foreach($fields as $field)
        {
            if($this->$field){
                $count ++;
            }
        }
        return $count;
    }

    public function businessDocumentRequests()
    {
        return $this->hasMany(BusinessDocumentRequest::class);
    }

    public function hasPendingRequest()
    {
        return $this->businessDocumentRequests()->where('status','pending')->count();
    }
}
