<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return $this->sendSuccess('Business document of type ' . strtoupper($request->type) . ' uploaded and saved successfully.', ["business" => $business->load('businessDocument')]);
    }
}
