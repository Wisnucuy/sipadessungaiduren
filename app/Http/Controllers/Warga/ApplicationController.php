<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use App\Models\Attachment;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    /**
     * Daftar semua pengajuan milik warga yang login
     */
    public function index()
    {
        $user = Auth::guard('web')->user();

        $applications = Application::where('user_id', $user->id)
            ->with('letterType')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('warga.applications.index', compact('applications'));
    }

    /**
     * Form pengajuan surat — langkah 1: pilih jenis surat
     */
    public function create(Request $request)
    {
        $letterTypes = LetterType::active()->orderBy('name')->get();

        // Jika sudah pilih jenis surat, ambil detailnya
        $selectedLetterType = null;
        if ($request->has('letter_type_id')) {
            $selectedLetterType = LetterType::active()
                ->findOrFail($request->letter_type_id);
        }

        return view('warga.applications.create',
            compact('letterTypes', 'selectedLetterType'));
    }

    /**
     * Simpan pengajuan baru
     */
    public function store(Request $request)
    {
        // ── Validasi input ────────────────────────────────
        $request->validate([
            'letter_type_id' => ['required', 'exists:letter_types,id'],
            'purpose'        => ['required', 'string', 'min:10', 'max:1000'],
            'tempat_lahir'   => ['required', 'string', 'max:100'],
            'tanggal_lahir'  => ['required', 'date'],
            'jenis_kelamin'  => ['required', 'in:Laki-laki,Perempuan'],
            'agama'          => ['required', 'string', 'max:50'],
            'pekerjaan'      => ['required', 'string', 'max:100'],

            // Dokumen wajib
            'ktp'            => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120', // 5MB
            ],
            'kk'             => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
            'surat_pengantar_rt' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            // Dokumen pendukung opsional
            'dokumen_pendukung' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
        ], [
            'letter_type_id.required'      => 'Jenis surat wajib dipilih.',
            'letter_type_id.exists'        => 'Jenis surat tidak valid.',
            'purpose.required'             => 'Keperluan surat wajib diisi.',
            'purpose.min'                  => 'Keperluan surat minimal 10 karakter.',
            'ktp.required'                 => 'File KTP wajib diupload.',
            'ktp.mimes'                    => 'File KTP harus berformat jpg, jpeg, png, atau pdf.',
            'ktp.max'                      => 'Ukuran file KTP maksimal 5 MB.',
            'kk.required'                  => 'File KK wajib diupload.',
            'kk.mimes'                     => 'File KK harus berformat jpg, jpeg, png, atau pdf.',
            'kk.max'                       => 'Ukuran file KK maksimal 5 MB.',
            'surat_pengantar_rt.required'  => 'Surat Pengantar RT wajib diupload.',
            'surat_pengantar_rt.mimes'     => 'Surat Pengantar RT harus berformat jpg, jpeg, png, atau pdf.',
            'surat_pengantar_rt.max'       => 'Ukuran Surat Pengantar RT maksimal 5 MB.',
            'dokumen_pendukung.mimes'      => 'Dokumen pendukung harus berformat jpg, jpeg, png, atau pdf.',
            'dokumen_pendukung.max'        => 'Ukuran dokumen pendukung maksimal 5 MB.',
        ]);

        $user = Auth::guard('web')->user();

        // ── Proses dalam transaksi database ──────────────
        // Jika salah satu langkah gagal, semua dibatalkan
        DB::transaction(function () use ($request, $user) {

            // 1. Buat nomor pengajuan otomatis
            $applicationNumber = Application::generateApplicationNumber();

            // 2. Simpan data pengajuan
            $application = Application::create([
                'application_number' => $applicationNumber,
                'user_id'            => $user->id,
                'letter_type_id'     => $request->letter_type_id,
                'status'             => Application::STATUS_PENDING,
                'purpose'            => $request->purpose,
                'applicant_data'     => [
                    'name'           => $user->name,
                    'nik'            => $user->nik,
                    'address'        => $user->address,
                    'phone'          => $user->phone,
                    'tempat_lahir'   => $request->tempat_lahir,
                    'tanggal_lahir'  => $request->tanggal_lahir,
                    'jenis_kelamin'  => $request->jenis_kelamin,
                    'agama'          => $request->agama,
                    'pekerjaan'      => $request->pekerjaan,
                ],
            ]);

            // 3. Upload dan simpan dokumen
            $documents = [
                'ktp'                => $request->file('ktp'),
                'kk'                 => $request->file('kk'),
                'surat_pengantar_rt' => $request->file('surat_pengantar_rt'),
            ];

            // Tambah dokumen pendukung jika ada
            if ($request->hasFile('dokumen_pendukung')) {
                $documents['dokumen_pendukung'] = $request->file('dokumen_pendukung');
            }

            foreach ($documents as $docType => $file) {
                $this->uploadDocument($application, $docType, $file);
            }

            // 4. Catat riwayat status awal
            ApplicationStatusHistory::create([
                'application_id'  => $application->id,
                'old_status'      => null,
                'new_status'      => Application::STATUS_PENDING,
                'changed_by'      => $user->name,
                'changed_by_type' => 'warga',
                'notes'           => 'Pengajuan surat baru dibuat oleh warga.',
            ]);

            // Simpan ID pengajuan untuk redirect
            session(['new_application_id' => $application->id]);
        });

        $applicationId = session('new_application_id');

        return redirect()
            ->route('warga.applications.show', $applicationId)
            ->with('success', 'Pengajuan surat berhasil dikirim! Silakan pantau status pengajuan Anda.');
    }

    /**
     * Detail pengajuan + tracking status
     */
    public function show($id)
    {
        $user = Auth::guard('web')->user();

        // Pastikan pengajuan ini milik warga yang login
        $application = Application::where('user_id', $user->id)
            ->with(['letterType', 'attachments', 'statusHistories'])
            ->findOrFail($id);

        return view('warga.applications.show', compact('application'));
    }

    /**
     * Form edit pengajuan yang ditolak (status: rejected)
     */
    public function edit($id)
    {
        $user = Auth::guard('web')->user();

        $application = Application::where('user_id', $user->id)
            ->with(['letterType', 'attachments'])
            ->findOrFail($id);

        // Hanya bisa diedit jika status rejected
        if (!$application->isEditable()) {
            return redirect()
                ->route('warga.applications.show', $id)
                ->with('error', 'Pengajuan ini tidak dapat diedit karena statusnya bukan Ditolak.');
        }

        return view('warga.applications.edit', compact('application'));
    }

    /**
     * Update pengajuan yang ditolak
     */
    public function update(Request $request, $id)
    {
        $user = Auth::guard('web')->user();

        $application = Application::where('user_id', $user->id)
            ->findOrFail($id);

        if (!$application->isEditable()) {
            return redirect()
                ->route('warga.applications.show', $id)
                ->with('error', 'Pengajuan ini tidak dapat diedit.');
        }

        $request->validate([
            'purpose'        => ['required', 'string', 'min:10', 'max:1000'],
            'tempat_lahir'   => ['required', 'string', 'max:100'],
            'tanggal_lahir'  => ['required', 'date'],
            'jenis_kelamin'  => ['required', 'in:Laki-laki,Perempuan'],
            'agama'          => ['required', 'string', 'max:50'],
            'pekerjaan'      => ['required', 'string', 'max:100'],
            'ktp'            => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'kk'      => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'surat_pengantar_rt'  => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'dokumen_pendukung'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'purpose.required' => 'Keperluan surat wajib diisi.',
            'purpose.min'      => 'Keperluan surat minimal 10 karakter.',
        ]);

        DB::transaction(function () use ($request, $application, $user) {

            // Update keperluan surat
            $application->update([
                'purpose'        => $request->purpose,
                'status'         => Application::STATUS_PENDING,
                'notes'          => null,
                'applicant_data' => array_merge($application->applicant_data ?? [], [
                    'tempat_lahir'  => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'agama'         => $request->agama,
                    'pekerjaan'     => $request->pekerjaan,
                ]),
            ]);

            // Upload ulang dokumen jika ada file baru
            $docTypes = ['ktp', 'kk', 'surat_pengantar_rt', 'dokumen_pendukung'];

            foreach ($docTypes as $docType) {
                if ($request->hasFile($docType)) {
                    // Hapus file lama
                    $oldAttachment = $application->attachments()
                        ->where('document_type', $docType)
                        ->first();

                    if ($oldAttachment) {
                        Storage::disk('public')->delete($oldAttachment->file_path);
                        $oldAttachment->delete();
                    }

                    // Upload file baru
                    $this->uploadDocument(
                        $application,
                        $docType,
                        $request->file($docType)
                    );
                }
            }

            // Catat riwayat status
            ApplicationStatusHistory::create([
                'application_id'  => $application->id,
                'old_status'      => Application::STATUS_REJECTED,
                'new_status'      => Application::STATUS_PENDING,
                'changed_by'      => $user->name,
                'changed_by_type' => 'warga',
                'notes'           => 'Warga memperbaiki data dan mengajukan ulang.',
            ]);
        });

        return redirect()
            ->route('warga.applications.show', $id)
            ->with('success', 'Pengajuan berhasil diperbaiki dan dikirim ulang!');
    }

    /**
     * Hapus pengajuan jika masih pending dan belum diverifikasi admin.
     */
    public function destroy($id)
    {
        $user = Auth::guard('web')->user();

        $application = Application::where('user_id', $user->id)
            ->with('attachments')
            ->findOrFail($id);

        if (!$application->isDeletable()) {
            return redirect()
                ->route('warga.applications.index')
                ->with('error', 'Pengajuan ini tidak bisa dihapus karena sudah diproses oleh admin.');
        }

        foreach ($application->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $application->attachments()->delete();
        $application->statusHistories()->delete();
        $application->delete();

        return redirect()
            ->route('warga.applications.index')
            ->with('success', 'Pengajuan berhasil dihapus.');
    }

    /**
     * Helper: upload satu dokumen dan simpan ke database
     */
    private function uploadDocument(Application $application, string $docType, $file): void
    {
        // Buat nama file unik
        $fileName  = time() . '_' . $docType . '.' . $file->getClientOriginalExtension();

        // Path penyimpanan: attachments/2025/01/
        $folder    = 'attachments/' . date('Y/m');
        $filePath  = $file->storeAs($folder, $fileName, 'public');

        // Simpan ke database
        Attachment::create([
            'application_id' => $application->id,
            'document_type'  => $docType,
            'file_path'      => $filePath,
            'file_name'      => $file->getClientOriginalName(),
            'file_size'      => $file->getSize(),
            'mime_type'      => $file->getMimeType(),
        ]);
    }
}