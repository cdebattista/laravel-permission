<?php
namespace Cdebattista\LaravelPermission\Http\Middleware;

use Illuminate\Http\Response;

class Permission
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        if(!$request->route()->getAction('permissions')){
            return $next($request);
        }
        return $request->user()->hasPermissions($request->route()->getAction('permissions')) ? $next($request) : abort(Response::HTTP_UNAUTHORIZED);
    }
}