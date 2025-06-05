<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIdMatchesAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeUserId = (string) $request->route('id');

        if (Auth::guard('admin')->check()) {
            $authUserId = (string) Auth::guard('admin')->id;
        } elseif (Auth::guard('lecturer')->check()) {
            $authUserId = (string) Auth::guard('lecturer')->id;
        } else {
            $authUserId = (string) Auth::guard('student')->user()->id;
        }


        if ($routeUserId !== $authUserId) {
            abort(401, 'Unauthorized');
        }

        return $next($request);
    }
}
