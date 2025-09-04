<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'), $request->remeber ?? 0)) {
            return redirect()->route('dashboard.home')->with('success', 'تم تسجيل الدخول بنجاح');
        }
        return redirect()->back()->with('error', 'البيانات غير صحيحه');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'تم تسجيل الخروج بنجاح');
    }
}