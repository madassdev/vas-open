<?php

namespace App\Http\Controllers;

use App\Models\ActionRequest;
use App\Models\Biller;
use Exception;
use Illuminate\Http\Request;

class ActionRequestController extends Controller
{

    public function getActionRequests(Request $request)
    {
        $per_page = $request->per_page ?? 20;
        $actionRequest = ActionRequest::latest()->paginate($per_page);
        return $this->sendSuccess("Action requests fetched successfully", [
            "action_requests" => $actionRequest
        ]);
    }
    public function createUser(Request $request)
    {
    }

    public function makeUpdateBiller(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            "biller_id" => "required|exists:billers,id", "name" => "required|sometimes|string",
            "name" => "required|sometimes|string",
            "shortname" => "required|sometimes|string|unique:billers,shortname," . $request->biller_id,
            "vendor_code" => "required|sometimes|unique:billers,vendor_code," . $request->biller_id,
            "enabled" => "required|sometimes|boolean"
        ]);

        $handler = [
            "type" => sc('controllerMethod'),
            "class" => get_class($this),
            "method" => 'updateBiller',
        ];

        $payload = $request->all();
        $maker_id = $user->id;
        $biller = Biller::find($request->biller_id);

        $initial_data = [
            "type" => Biller::class,
            "data" => $biller
        ];

        $data = $request->all();
        $handler['args'] = $data;
        $actionRequestData = [
            "maker_id" => $maker_id,
            "payload" => $payload,
            "handler" => $handler,
            "initial_data" => $initial_data,
            "status" => "pending",
        ];
        $actionRequest = ActionRequest::create($actionRequestData);
        return $this->sendSuccess("Action request created successfully", [
            "action_request" => $actionRequest
        ]);

        return $actionRequestData;
    }

    public function updateBiller(array $data)
    {
        try {
            $biller = Biller::findOrFail($data['biller_id']);
            unset($data["biller_id"]);
            $biller->update($data);
        } catch (Exception $e) {
            $error = "[ERROR]: " . $e->getMessage() . " | " . $e->getFile() . " on line " . $e->getLine();
            return (object)[
                "status" => false,
                "message" => $error,
                "data" => [
                    "type" => "error",
                    "data" => $error,
                ],
            ];
        }
        return (object)[
            "status" => true,
            "message" => "Updated successfully",
            "data" => [
                "type" => Biller::class,
                "data" => $biller
            ],
        ];
    }

    public function checkAction(Request $request, ActionRequest $actionRequest)
    {
        $user = auth()->user();
        $request->validate([
            'action' => 'required|in:approve,reject'
        ]);
        $status = false;
        $message = "";
        $handler = (object) $actionRequest->handler;
        $process = null;
        if ($actionRequest->status !== "pending") {
            return $this->sendError("Action request already processed", [], 400);
        }

        if ($request->action === "reject") {
            $actionRequest->checker_id = $user->id;
            $actionRequest->treated_at = now();
            $actionRequest->status = 'rejected';
            $actionRequest->save();
            return $this->sendSuccess('Action Request Rejected successfully', []);
        }
        if ($handler->type == sc('controllerMethod')) {
            $process = call_user_func([$handler->class, $handler->method], $handler->args);
        }
        $status = $process->status;
        $message = $process->message;
        if ($status) {
            $actionRequest->final_data = $process->data;
            $actionRequest->checker_id = $user->id;
            $actionRequest->status = 'successful';
            $actionRequest->treated_at = now();
            $actionRequest->save();
            return $this->sendSuccess($message, [$actionRequest]);
        } else {
            $actionRequest->status = 'failed';
            $actionRequest->final_data = $process->data;
            $actionRequest->checker_id = $user->id;
            $actionRequest->treated_at = now();
            $actionRequest->save();
            return $this->sendError($message);
        }
    }

    public function approveBiller($data)
    {
        return $data;
    }
}
