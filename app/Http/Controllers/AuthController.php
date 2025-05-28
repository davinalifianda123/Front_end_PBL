<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        try {
            // Kirim POST ke backend API login
            $response = Http::post('http://localhost:8001/api/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['access_token']) && isset($data['refresh_token'])) {
                // Set access token (misalnya 15 menit = 15)
                $accessCookie = cookie('jwt_token', $data['access_token'], 15);

                // Set refresh token (misalnya 7 hari = 60 * 24 * 7 = 10080 menit)
                $refreshCookie = cookie('refresh_token', $data['refresh_token'], 10080);

                return redirect(route('dashboard.index'))
                    ->withCookie($accessCookie)
                    ->withCookie($refreshCookie)
                    ->with('success', 'Login berhasil!');
            }

            return back()->withErrors(['login' => 'Login gagal, token tidak diterima.']);
        } catch (\Exception $e) {
            return back()->withErrors(['login' => 'Login gagal: ' . $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        // Hapus kedua cookie: jwt_token dan refresh_token
        return redirect('/login')
            ->withCookie(Cookie::forget('jwt_token'))
            ->withCookie(Cookie::forget('refresh_token'))
            ->with('success', 'Logout berhasil!');
    }
}