<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role == $role) {
            return $next($request);
        }
        if(!Auth::check()) {
            return response()->json(['error' => '  سجل دخول'], 403);

        }

        if(Auth::user()->role != $role) {
            return response()->json(['error' => ' غير مصرح ل'], 403);
        }
    }


}
