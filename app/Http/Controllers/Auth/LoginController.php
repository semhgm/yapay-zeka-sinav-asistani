<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            if ($user->hasRole('superadmin')) {
                return redirect()->route('admin.index');
            }

            if ($user->hasRole('teacher')) {
                return redirect()->route('teacher.index');
            }

            if ($user->hasRole('student')) {
                return redirect()->route('student.index');
            }

            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Rol tanımı yapılmamış.']);
        }

        return back()->withErrors(['email' => 'Bilgiler hatalı.'])->withInput();
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
