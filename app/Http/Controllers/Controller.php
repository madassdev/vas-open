<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendSuccess($message = "Request Successful", $data = [], $httpcode = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => array_merge([], $data)
        ], $httpcode);
    }

    public function sendError($message = "Request Failed", $data = [], $httpcode = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => array_merge([], $data)
        ], $httpcode);
    }

    public function authorizeAdmin($permission)
    {
        $user = auth()->user();
        if(!$user->can($permission)){
            if(!$user->hasRole(sc('SUPER_ADMIN_ROLE')))
            sr("User does not have the permission: [" . strtoupper($permission) . "]", [], 403);
        }

    }
}
