<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterType;
use Illuminate\Http\Request;

class LetterTypeController extends Controller
{
    /**
     * Daftar semua jenis surat
     */
    public function index()
    {
        $letterTypes = LetterType::orderBy('name')->paginate(10);
        return view('admin.letter-types.index', compact('letterTypes'));
    }

    /**
     * Form tambah jenis surat
     */
    public function create()
    {
        return view('admin.letter-types.create');
    }

    /**
     * Simpan jenis surat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => ['required', 'string', 'max:255',
                                   'unique:letter_types,name'],
            'description'      => ['nullable', 'string'],
            'requirements'     => ['nullable', 'string'],
            'processing_time'  => ['required', 'string', 'max:100'],
            'template_content' => ['nullable', 'string'],
            // ✅ Hapus validasi boolean — kita handle manual
        ], [
            'name.required'            => 'Nama jenis surat wajib diisi.',
            'name.unique'              => 'Nama jenis surat sudah ada.',
            'processing_time.required' => 'Estimasi waktu proses wajib diisi.',
        ]);

        $requirements = $this->parseRequirements($request->requirements);

        LetterType::create([
            'name'             => $request->name,
            'description'      => $request->description,
            'requirements'     => $requirements,
            'processing_time'  => $request->processing_time,
            'template_content' => $request->template_content,
            // ✅ Gunakan has() — true jika checkbox dicentang, false jika tidak
            'is_active'        => $request->has('is_active') ? true : false,
        ]);

        return redirect()
            ->route('admin.letter-types.index')
            ->with('success', 'Jenis surat berhasil ditambahkan.');
    }

    /**
     * Form edit jenis surat
     */
    public function edit($id)
    {
        $letterType = LetterType::findOrFail($id);
        return view('admin.letter-types.edit', compact('letterType'));
    }

    /**
     * Update jenis surat
     */
    public function update(Request $request, $id)
    {
        $letterType = LetterType::findOrFail($id);

        $request->validate([
            'name'             => ['required', 'string', 'max:255',
                                   'unique:letter_types,name,' . $id],
            'description'      => ['nullable', 'string'],
            'requirements'     => ['nullable', 'string'],
            'processing_time'  => ['required', 'string', 'max:100'],
            'template_content' => ['nullable', 'string'],
            // ✅ Hapus validasi boolean
        ], [
            'name.required'            => 'Nama jenis surat wajib diisi.',
            'name.unique'              => 'Nama jenis surat sudah digunakan.',
            'processing_time.required' => 'Estimasi waktu proses wajib diisi.',
        ]);

        $requirements = $this->parseRequirements($request->requirements);

        $letterType->update([
            'name'             => $request->name,
            'description'      => $request->description,
            'requirements'     => $requirements,
            'processing_time'  => $request->processing_time,
            'template_content' => $request->template_content,
            // ✅ Sama seperti store
            'is_active'        => $request->has('is_active') ? true : false,
        ]);

        return redirect()
            ->route('admin.letter-types.index')
            ->with('success', 'Jenis surat berhasil diperbarui.');
    }

    /**
     * Toggle aktif/nonaktif
     */
    public function toggleStatus($id)
    {
        $letterType = LetterType::findOrFail($id);
        $letterType->update(['is_active' => !$letterType->is_active]);

        $status = $letterType->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success',
            "Jenis surat \"{$letterType->name}\" berhasil {$status}.");
    }

    /**
     * Hapus jenis surat
     */
    public function destroy($id)
    {
        $letterType = LetterType::findOrFail($id);

        if ($letterType->applications()->count() > 0) {
            return back()->with('error',
                'Jenis surat tidak bisa dihapus karena sudah digunakan '
                . 'dalam pengajuan. Gunakan fitur nonaktifkan.');
        }

        $letterType->delete();

        return redirect()
            ->route('admin.letter-types.index')
            ->with('success', 'Jenis surat berhasil dihapus.');
    }

    /**
     * Helper: ubah teks requirements menjadi array
     */
    private function parseRequirements(?string $text): array
    {
        if (empty($text)) return [];

        return array_values(array_filter(
            array_map('trim', explode("\n", $text))
        ));
    }
}