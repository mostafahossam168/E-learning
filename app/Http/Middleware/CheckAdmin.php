<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->type->value != 'admin' && auth()->user()->type->value != 'teacher') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'غير مصرح لك بالدخول ');
        }
        return $next($request);
    }
}
