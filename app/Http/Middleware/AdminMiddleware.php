<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {

            $roles = Auth::user()->roles->pluck('name_en')->toArray();
            if (in_array('Admin', $roles)) {
                return $next($request);
            } else {
                return response()->json(["message" => 'Acess denied as you are not admin'], 401);
            }
        } else {
            return response()->json(["message" => 'Login to acess resource'], 401);

        }
    }
}
