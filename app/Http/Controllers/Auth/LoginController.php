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
        request()->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        if (Auth::attempt($request->only('email','password'))){
            return redirect()->route('admin.index');
        }

        return back()->withErrors(['email' => 'Bilgiler hatalı.'])->withInput();
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }
}
