<?php

namespace App\Services;

use App\Http\Controllers\BusinessDocumentController;
use App\Models\ActionRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

class MakerCheckerService
{
    private $action;
    private $route_data;
    private $route_name;

    public function __construct(ActionRequest $action)
    {
        $this->action = $action;
        $this->route_name = Route::currentRouteName();
        $this->route_data = Route::getByName($this->route_name);
    }

    public function handle()
    {
        $handler = (object) $this->getHandlerDetails();
        try {
            if ($handler->type == sc('controllerMethod')) {
                $process = call_user_func([$handler->class, $handler->method], request());
                if (@$process['success']) {
                    $this->completeAction($process["data"]);
                    return response()->json([
                        "success" => true,
                        'message' => @$process['message'] ?? 'Action has been successfully saved for approval.',
                        'data' => []
                    ], 200);
                    return true;
                } else {
                    return response()->json([
                        "success" => false,
                        'message' => @$process['message'] ?? 'Action not successful',
                        'data' => []
                    ], 400);
                }
            }
        } 
        catch(ValidationException $e){
            throw $e;
        }
        catch (\Throwable $th) {
            // throw $th;
            response()->json([
                "success" => false,
                "message" => "[UNKNOWN_ERROR]: " . $th->getMessage() ?? $th['message']
            ], 400)->throwResponse();
            return false;
        }

        return $handler;
    }

    public function completeAction($data)
    {
        $request = request();
        $handler = [
            "url" => $request->url(),
            "method" => $request->method(),
            "payload" => $request->all(),
            "route_name" => $this->route_name,
            "route_data" => $this->route_data,
        ];
        $action = $this->action;
        $action->maker_id = auth()->id();
        $action->status = "pending";
        $action->payload = $request->all();
        $action->handler = $handler;
        $action->title = $data["title"];
        $action->description = $data["description"];
        $action->view_link = $data["view_link"];
        $action->save();
        return true;
    }

    public function getRouteTitle()
    {
        $route_title = str_replace('admin.', '',  $this->route_name);
        return $route_title;
    }

    public function getHandlerDetails()
    {
        switch ($this->route_name) {
            case 'admin.businesses.approve_documents':
                return [
                    "type" => sc('controllerMethod'),
                    "class" => new BusinessDocumentController(),
                    "method" => 'makeAction',
                ];
                break;

            default:
                # code...
                break;
        }
    }
}
