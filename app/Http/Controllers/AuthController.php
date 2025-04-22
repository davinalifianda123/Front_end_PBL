<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $request->authenticate();

            if (auth()->user()->hasRole('Admin')) {
                return redirect()->intended(route('users.index'));
            } else if (auth()->user()->hasRole('Supplier')) {
                auth()->logout();
                return back()->withErrors(['email' => 'Akun ini tidak memiliki akses ke website ini.'])->withInput($request->only('email', 'password'));
            } else {
                return redirect()->intended(route('barangs.index'));
            }
        } catch (ValidationException $exception) {
            return back()->withErrors($exception->errors())->withInput($request->only('email', 'password'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
