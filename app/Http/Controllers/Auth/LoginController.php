<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Gunakan guard 'web' secara eksplisit
        if (Auth::guard('web')->check()) {
            return redirect()->route('warga.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nik'      => ['required', 'string', 'size:16'],
            'password' => ['required', 'string'],
        ], [
            'nik.required'      => 'NIK wajib diisi.',
            'nik.size'          => 'NIK harus 16 digit.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = [
            'nik'      => $request->nik,
            'password' => $request->password,
        ];

        // Login dengan guard 'web' secara eksplisit
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('warga.dashboard'))
                ->with('success', 'Selamat datang, ' . Auth::guard('web')->user()->name . '!');
        }

        return back()
            ->withInput($request->only('nik'))
            ->withErrors([
                'nik' => 'NIK atau password yang Anda masukkan salah.',
            ]);
    }

    public function logout(Request $request)
    {
        // Logout hanya guard 'web', tidak menyentuh guard 'admin'
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil keluar.');
    }
}