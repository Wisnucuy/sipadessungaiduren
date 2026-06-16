<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /**
     * Halaman pengaturan — daftar semua admin
     */
    public function index()
    {
        $admins  = AdminUser::orderBy('name')->get();
        $current = Auth::guard('admin')->user();

        return view('admin.settings.index',
            compact('admins', 'current'));
    }

    /**
     * Form tambah admin baru
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Simpan admin baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email',
                           'unique:admin_users,email'],
            'password' => ['required', 'string',
                           'min:8', 'confirmed'],
            'role'     => ['required',
                           'in:superadmin,admin,operator'],
        ], [
            'name.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'role.required'     => 'Role wajib dipilih.',
        ]);

        AdminUser::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Akun admin baru berhasil ditambahkan.');
    }

    /**
     * Form edit admin
     */
    public function edit($id)
    {
        $admin   = AdminUser::findOrFail($id);
        $current = Auth::guard('admin')->user();

        return view('admin.settings.edit',
            compact('admin', 'current'));
    }

    /**
     * Update data admin
     */
    public function update(Request $request, $id)
    {
        $admin = AdminUser::findOrFail($id);

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email',
                        'unique:admin_users,email,' . $id],
            'role'  => ['required',
                        'in:superadmin,admin,operator'],
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah digunakan.',
            'role.required'  => 'Role wajib dipilih.',
        ]);

        $admin->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Data admin berhasil diperbarui.');
    }

    /**
     * Ganti password admin
     */
    public function changePassword(Request $request, $id)
    {
        $admin   = AdminUser::findOrFail($id);
        $current = Auth::guard('admin')->user();

        $request->validate([
            'new_password' => ['required', 'string',
                               'min:8', 'confirmed'],
        ], [
            'new_password.required'  => 'Password baru wajib diisi.',
            'new_password.min'       => 'Password minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Jika ganti password sendiri, cek password lama
        if ($current->id === $admin->id) {
            $request->validate([
                'current_password' => ['required', 'string'],
            ], [
                'current_password.required' => 'Password saat ini wajib diisi.',
            ]);

            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors([
                    'current_password' => 'Password saat ini tidak sesuai.',
                ]);
            }
        }

        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Password berhasil diubah.');
    }

    /**
     * Hapus admin (tidak bisa hapus diri sendiri)
     */
    public function destroy($id)
    {
        $current = Auth::guard('admin')->user();

        if ($current->id == $id) {
            return back()->with('error',
                'Anda tidak bisa menghapus akun sendiri.');
        }

        $admin = AdminUser::findOrFail($id);
        $admin->delete();

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Akun admin berhasil dihapus.');
    }
}