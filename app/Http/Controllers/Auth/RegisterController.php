<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman form register
     */
    public function showRegisterForm()
    {
        // Jika sudah login, langsung ke dashboard
        if (Auth::check()) {
            return redirect()->route('warga.dashboard');
        }

        return view('auth.register');
    }

    /**
     * Proses data register dari form
     */
    public function register(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nik'      => [
                'required',
                'string',
                'size:16',          // NIK harus tepat 16 digit
                'unique:users,nik', // NIK belum terdaftar
                'regex:/^[0-9]+$/', // Hanya angka
            ],
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'address'  => ['required', 'string', 'max:500'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            // Pesan error dalam Bahasa Indonesia
            'nik.required'      => 'NIK wajib diisi.',
            'nik.size'          => 'NIK harus terdiri dari 16 digit.',
            'nik.unique'        => 'NIK sudah terdaftar. Silakan login.',
            'nik.regex'         => 'NIK hanya boleh berisi angka.',
            'name.required'     => 'Nama lengkap wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'address.required'  => 'Alamat wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
        ]);

        // Simpan data warga baru
        $user = User::create([
            'nik'      => $request->nik,
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'password' => Hash::make($request->password),
        ]);

        // Login otomatis setelah register berhasil
        Auth::guard('web')->login($user);

        return redirect()
            ->route('warga.dashboard')
            ->with('success', 'Selamat datang, ' . $user->name . '! Akun Anda berhasil dibuat.');
    }
}