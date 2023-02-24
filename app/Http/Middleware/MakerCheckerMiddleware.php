<?php

namespace App\Http\Middleware;

use App\Models\ActionRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MakerCheckerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->is_check) {
            // Ensure validity
            return $next($request);
        }
        // $route_data =  Route::getByName('admin.businesses.approve_documents');
        $route_name = Route::currentRouteName();
        $url = $request->url();
        $req_method = $request->method();
        $handler = [
            "url" => $url,
            "method" => $req_method,
            "payload" => $request->all(),
            "route_name" => $route_name,
            // "route_data" => $route_data,
        ];

        // $hal;
        $action = new ActionRequest();
        $action->maker_id = auth()->id();
        $action->status = "pending";
        $action->payload = $request->all();
        $action->handler = $handler;
        $action->save();
        return response()->json(
            [
                'status' => true,
                'message' => "Action has been successfully saved for approval.",
                'data' => ["action_request"=>$action]
            ]
        );
        return $next($request);
    }
}
