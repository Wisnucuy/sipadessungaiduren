<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use App\Models\LetterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Daftar semua pengajuan dengan search & filter
     */
    public function index(Request $request)
    {
        $query = Application::with(['user', 'letterType'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('letter_type_id')) {
            $query->byLetterType($request->letter_type_id);
        }

        $applications = $query->paginate(15)->withQueryString();
        $letterTypes  = LetterType::orderBy('name')->get();
        $statusList   = Application::statusList();

        return view('admin.applications.index',
            compact('applications', 'letterTypes', 'statusList'));
    }

    /**
     * Detail pengajuan
     */
    public function show($id)
    {
        $application = Application::with([
            'user',
            'letterType',
            'attachments',
            'statusHistories',
            'reviewer',
        ])->findOrFail($id);

        $statusList = Application::statusList();

        return view('admin.applications.show',
            compact('application', 'statusList'));
    }

    /**
     * Ubah status ke Verifying
     */
    public function verify($id)
    {
        $application = Application::findOrFail($id);
        $admin       = Auth::guard('admin')->user();

        if ($application->status !== Application::STATUS_PENDING) {
            return back()->with('error',
                'Hanya pengajuan berstatus Menunggu yang bisa diverifikasi.');
        }

        $this->changeStatus(
            $application,
            Application::STATUS_VERIFYING,
            $admin,
            'Admin mulai memverifikasi pengajuan.'
        );

        return back()->with('success',
            'Status pengajuan diubah menjadi Diverifikasi.');
    }

    /**
     * Approve pengajuan
     */
    public function approve(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $admin       = Auth::guard('admin')->user();

        if ($application->status !== Application::STATUS_VERIFYING) {
            return back()->with('error',
                'Hanya pengajuan berstatus Diverifikasi yang bisa disetujui.');
        }

        // Gunakan ?? agar null dari textarea tidak menyebabkan error
        $notes = $request->input('notes');
        $notes = (!empty(trim($notes ?? '')))
            ? $notes
            : 'Pengajuan disetujui oleh admin.';

        $this->changeStatus(
            $application,
            Application::STATUS_APPROVED,
            $admin,
            $notes
        );

        $application->update([
            'reviewed_by' => $admin->id,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    /**
     * Reject pengajuan dengan catatan
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'notes' => ['required', 'string', 'min:10'],
        ], [
            'notes.required' => 'Catatan penolakan wajib diisi.',
            'notes.min'      => 'Catatan penolakan minimal 10 karakter.',
        ]);

        $application = Application::findOrFail($id);
        $admin       = Auth::guard('admin')->user();

        if (!in_array($application->status, [
            Application::STATUS_PENDING,
            Application::STATUS_VERIFYING,
        ])) {
            return back()->with('error', 'Pengajuan ini tidak bisa ditolak.');
        }

        $this->changeStatus(
            $application,
            Application::STATUS_REJECTED,
            $admin,
            $request->notes
        );

        $application->update([
            'notes'       => $request->notes,
            'reviewed_by' => $admin->id,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    /**
     * Ubah status ke Completed
     */
    public function complete($id)
    {
        $application = Application::findOrFail($id);
        $admin       = Auth::guard('admin')->user();

        if ($application->status !== Application::STATUS_APPROVED) {
            return back()->with('error',
                'Hanya pengajuan berstatus Disetujui yang bisa diselesaikan.');
        }

        $this->changeStatus(
            $application,
            Application::STATUS_COMPLETED,
            $admin,
            'Surat telah selesai dibuat dan siap diambil.'
        );

        $application->update([
            'completed_at' => now(),
        ]);

        return back()->with('success',
            'Pengajuan telah diselesaikan. Surat siap diambil.');
    }

    /**
     * Helper: ubah status + catat riwayat
     * Tanda ? pada ?string berarti parameter boleh null
     */
    private function changeStatus(
        Application $application,
        string $newStatus,
        $admin,
        ?string $notes = ''
    ): void {
        $oldStatus = $application->status;

        $application->update(['status' => $newStatus]);

        ApplicationStatusHistory::create([
            'application_id'  => $application->id,
            'old_status'      => $oldStatus,
            'new_status'      => $newStatus,
            'changed_by'      => $admin->name,
            'changed_by_type' => 'admin',
            'notes'           => $notes ?? '',
        ]);
    }
}