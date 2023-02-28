<?php

namespace App\Http\Middleware;

use App\Models\ActionRequest;
use App\Models\BusinessDocumentRequest;
use App\Services\MakerCheckerService;
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
        // https://vasreseller.up-ng.com/admin/businesses/details/26

        if ($request->is_check) {
            // Ensure validity
            return $next($request);
        }
        $action = new ActionRequest();
        $service = new MakerCheckerService($action);
        return $service->handle();
    }

    public function getMeta($route_data)
    {
        $route_name = $route_data->getAction()['as'];
        $parameters = $route_data->parameters;
        switch ($route_name) {
            case 'admin.businesses.approve_documents':
                // $business = 
                return BusinessDocumentRequest::handleMakerChecker($parameters);
                break;

            default:
                # code...
                break;
        }
    }
}
