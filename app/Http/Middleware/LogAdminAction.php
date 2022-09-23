<?php

namespace App\Http\Middleware;

use App\Models\AdminActionLog;
use Closure;
use Illuminate\Http\Request;

class LogAdminAction
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
        $loggable_methods = ['POST', 'PUT', 'PATCH', "DELETE"];
        if (in_array(strtoupper($request->method()), $loggable_methods)) {
            $data = [
                'user_id' => auth()->id(),
                'request_method' => $request->method(),
                'request_path' => $request->path(),
                'request_body' => $request->all(),
                'request_ip' => $request->ip(),
                'request_origin' => $request->header('host'),
            ];
            AdminActionLog::create($data);
        }

        return $next($request);
    }
}
