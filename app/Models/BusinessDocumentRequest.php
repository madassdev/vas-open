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

    public static function handleMakerChecker($payload)
    {
        $action = request()->action;
        $path =  request()->path();
        $path =  str_replace("api/super/businesses/", "", $path);
        $path =  str_replace("/approve-documents", "", $path);
        $document_request = BusinessDocumentRequest::findOrFail($path);
        // $document_request->status = "reviewed";
        // $document_request->save();
        $document = $document_request->businessDocument;
        $business_id = $document_request['business_id'];
        $user = auth()->user();
        $business = Business::find($business_id);
        $view_link = "https://vasreseller.up-ng.com/admin/businesses/details/{$business_id}";
        $description = "{$user->first_name} {$user->last_name} tried to {$action} business documents on {$business->name}";
        $success = true;
        // $message="Unknown error";
        return compact("view_link", "description", "payload", "success", "message");
    }
}
