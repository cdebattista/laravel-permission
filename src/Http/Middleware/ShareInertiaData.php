<?php
namespace Cdebattista\LaravelPermission\Http\Middleware;

use Inertia\Inertia;

class ShareInertiaData
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
        Inertia::share([
            'hasPermissionFeature' => true,
            'UserPermissions' => function() use ($request){
                if(!$request->user()){
                    return;
                }
                return $request->user()->getPermissions();
            }
        ]);
        return $next($request);
    }
}