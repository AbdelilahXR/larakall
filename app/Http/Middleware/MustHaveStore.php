<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustHaveStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->check())
        {
            return $next($request);
        }

        $allowedRoles = [
            "super_admin",
            "agent"
        ];

        $prohibedRoutes = [
            "filament.admin.resources.orders.index",
            "filament.admin.resources.orders.edit",
            "filament.admin.resources.products.index",
            "filament.admin.pages.dashboard"
        ];

        if (auth()->check() && auth()->user()->hasAnyRole($allowedRoles)) {
            return $next($request);
        }

        if (auth()->user()->stores->count() == 0 && request()->routeIs($prohibedRoutes)) {
            return redirect()->route('filament.admin.resources.stores.index');
        }
        
        return $next($request);
    }
}
