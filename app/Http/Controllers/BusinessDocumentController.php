<?php

namespace App\Http\Controllers;

use App\Mail\UserWelcomeMail;
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
            "file" => "required|file|mimes:png,jpg,pdf,doc,docx",
        ]);

        // Get business documents
        $business = $user->business;
        $document = $business->businessDocument()->firstOrNew();

        if ($business->document_verified === 2) {
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

    public function showDocuments()
    {
        $user = auth()->user();
        $documents = $user->business->businessDocument;
        if (!$documents) {
            $documents = $user->business->businessDocument()->create([])->refresh();
        }
        return $this->sendSuccess("User Business Documents fetched successfully.", [
            "business_documents" => $documents,
            "document_status" => $user->business->document_verified
        ]);
    }
}
