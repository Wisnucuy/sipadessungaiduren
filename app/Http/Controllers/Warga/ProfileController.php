<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Halaman edit profil warga
     */
    public function edit()
    {
        $user = Auth::guard('web')->user();
        return view('warga.profile.edit', compact('user'));
    }

    /**
     * Update data profil warga
     */
    public function update(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['nullable', 'email',
                          'unique:users,email,' . $user->id],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
        ], [
            'name.required'    => 'Nama lengkap wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'email.unique'     => 'Email sudah digunakan.',
            'address.required' => 'Alamat wajib diisi.',
        ]);

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('warga.profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Ganti password warga
     */
    public function changePassword(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password'     => ['required', 'string',
                                   'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.min'          => 'Password baru minimal 8 karakter.',
            'new_password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()
            ->route('warga.profile.edit')
            ->with('success', 'Password berhasil diubah.');
    }
}