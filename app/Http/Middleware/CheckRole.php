<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @param  string  ...$roles
         * @return mixed
         */
        
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
   } 
}
