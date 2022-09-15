<?php

namespace App\Http\Controllers;

use App\Mail\UserWelcomeMail;
use App\Models\Business;
use App\Models\BusinessDocumentRequest;
use App\Services\MailApiService;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;

class BusinessDocumentController extends Controller
{
    //
    public function uploadDocuments(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            "type" => "required|string|in:cac_2,cac_7,certificate,director_1,director_2,director_3",
            "file" => "required|file|max:50000|mimes:png,jpg,pdf,doc,docx",
        ]);

        // Get business documents
        $business = $user->business;
        $document = $business->businessDocument()->firstOrNew();

        if ($business->document_verified === 1) {
            return $this->sendError("Business already verified", [], 403);
        }
        // Upload file
        $file = $request->file('file');
        $upload = cloudinary()->upload($file->getRealPath());
        $uploadedFileUrl =  $upload->getSecurePath();

        // Save file url per document_type
        switch ($request->type) {
            case 'cac_2':
                $document->cac_2 = $uploadedFileUrl;
                break;
            case 'cac_7':
                $document->cac_7 = $uploadedFileUrl;
                break;
            case 'certificate':
                $document->certificate = $uploadedFileUrl;
                break;
            case 'director_1':
                $document->director_1 = $uploadedFileUrl;
                break;
            case 'director_2':
                $document->director_2 = $uploadedFileUrl;
                break;
            case 'director_3':
                $document->director_3 = $uploadedFileUrl;
                break;

            default:
                return null;
                break;
        }
        $document->save();
        $business->document_verified = 0;
        $business->save();
        return $this->sendSuccess('Business document of type ' . strtoupper($request->type) . ' uploaded and saved successfully.', ["business" => $business->load('businessDocument')]);
    }

    public function requestApproval()
    {
        $user = auth()->user();
        $business = $user->business;
        $business_document = $business->businessDocument;

        if ($business_document->hasPendingRequest()) {
            return $this->sendError("There's a pending request on your business documents.", [], 403);
        }
        BusinessDocumentRequest::create([
            "business_id" => $business->id,
            "business_document_id" => $business_document->id,
        ]);

        // Notify Admin?
        return $this->sendSuccess('Business Documents submitted for approval.', [
            "business" => $business
        ]);
    }

    public function showDocuments()
    {
        $user = auth()->user();
        $business = $user->business;
        $documents = $business->businessDocument;
        $latest_document_request = BusinessDocumentRequest::whereBusinessId($business->id)->latest()->first();
        $comment = $latest_document_request ? $latest_document_request->comment : null;
        if (!$documents) {
            $documents = $business->businessDocument()->create([])->refresh();
        }

        if ($business->document_verified) {
            $status = "successful";
            $message = "Verified";
        } else {
            if (!$documents->businessDocumentRequests->count()) {
                $status = 0;
                $message = "Kindly upload document and request for approval";
            } else {

                if ($documents->hasPendingRequest()) {
                    $status = "pending";
                    $message = "Awaiting Approval";
                } else {
                    $status = "failed";
                    $message = "Failed. Kindly Re-upload";
                    $comment = $business->latest_document_comment;
                }
            }
        }

        return $this->sendSuccess("User Business Documents fetched successfully.", [
            "business_documents" => $documents,
            "document_status" => $business->document_verified,
            "documents_count" => $documents->documents_count,
            "status" => $status,
            "message" => $message,
            "comment" => $comment,
        ]);
    }
}
