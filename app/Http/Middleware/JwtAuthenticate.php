<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;

class JwtAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->cookie('jwt_token');
        $refreshToken = $request->cookie('refresh_token');

        if (!$accessToken && !$refreshToken) {
            return redirect('/login')->with('error', 'Tolong login terlebih dahulu.');
        }

        try {
            // Coba akses endpoint user
            $response = Http::withToken($accessToken)
                            ->get('http://localhost:8001/api/authenticated-user');

            if ($response->ok()) {
                return $next($request);
            }

            // Jika access token expired, coba refresh
            if (!$response->ok() && $refreshToken) {
                $refreshResponse = Http::post('http://localhost:8001/api/refresh', ['refresh_token' => $refreshToken]);

                if ($refreshResponse->ok()) {
                    $newAccessToken = $refreshResponse['access_token'];

                    $request->cookies->set('jwt_token', $newAccessToken);
                    Cookie::queue(cookie('jwt_token', $newAccessToken, 1));
                    
                    return $next($request);
                }
            }

            // Jika tidak bisa refresh atau gagal validasi
            return redirect('/login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Terjadi kesalahan. Silakan login kembali.');
        }
    }
}