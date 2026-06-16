<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillageProfileController extends Controller
{
    /**
     * Form edit profil desa
     */
    public function edit()
    {
        // Ambil profil desa (selalu ID 1)
        $village = VillageProfile::firstOrCreate([], [
            'village_name' => 'Desa Simpang Sungai Duren',
            'address'      => '-',
            'headman_name' => '-',
        ]);

        return view('admin.village-profile.edit', compact('village'));
    }

    /**
     * Update profil desa
     */
    public function update(Request $request)
    {
        $village = VillageProfile::firstOrFail();

        $request->validate([
            'village_name' => ['required', 'string', 'max:255'],
            'address'      => ['required', 'string'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'email'        => ['nullable', 'email', 'max:255'],
            'headman_name' => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'logo'         => ['nullable', 'image',
                               'mimes:jpg,jpeg,png',
                               'max:2048'],
        ], [
            'village_name.required' => 'Nama desa wajib diisi.',
            'address.required'      => 'Alamat desa wajib diisi.',
            'headman_name.required' => 'Nama kepala desa wajib diisi.',
            'logo.image'            => 'Logo harus berupa gambar.',
            'logo.mimes'            => 'Logo harus berformat JPG, JPEG, atau PNG.',
            'logo.max'              => 'Ukuran logo maksimal 2 MB.',
        ]);

        $data = [
            'village_name' => $request->village_name,
            'address'      => $request->address,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'headman_name' => $request->headman_name,
            'description'  => $request->description,
        ];

        // Upload logo baru jika ada
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($village->logo) {
                Storage::disk('public')->delete($village->logo);
            }

            // Simpan logo baru
            $data['logo'] = $request->file('logo')
                ->store('village', 'public');
        }

        $village->update($data);

        return redirect()
            ->route('admin.village-profile.edit')
            ->with('success', 'Profil desa berhasil diperbarui.');
    }
}