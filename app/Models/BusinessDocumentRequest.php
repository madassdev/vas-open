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

    public static function getMetaFromParams($params)
    {
        $action = request()->action;
        $document = $params['document_request'];
        $business_id = $document['business_id'];
        $user = auth()->user();
        $business = Business::find($business_id);

        $view_link = "https://vasreseller.up-ng.com/admin/businesses/details/{$business_id}";
        $description = "{$user->first_name} {$user->last_name} tried to {$action} business documents on {$business->name}";
        return compact("view_link", "description", "params");
        return $params;
    }
}
