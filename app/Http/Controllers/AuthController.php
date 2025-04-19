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

            if (Auth::user()->role->nama_role == 'Admin') {
                return redirect()->intended(route('users.index'));
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
