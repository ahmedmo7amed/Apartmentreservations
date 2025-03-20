<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;



class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ): Response
    {
//        if (!auth()->check() || !auth()->user()->hasPermissionTo($request->route()->getName())) {
//                abort(403);
//
//        }

        if (!auth()->check()) {
            //abort(403, 'يجب تسجيل الدخول للوصول إلى هذا المورد.');
        }
        $room = $request->route('room');

        if ($room && !auth()->user()->hasPermissionTo()) {
            abort(403);
        }
        return $next($request);
    }
}
