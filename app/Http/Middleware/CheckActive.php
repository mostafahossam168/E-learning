<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->status->value) {
            return $next($request);
        }
        auth()->logout();
        return redirect()->route('login')->with('error', 'حسابك غير مفعل برجاء التواصل مع خدمه العملاء');
    }
}
