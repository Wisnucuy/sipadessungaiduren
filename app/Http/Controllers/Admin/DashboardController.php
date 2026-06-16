<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\LetterType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        $stats = [
            'total'     => Application::count(),
            'pending'   => Application::where('status', 'pending')->count(),
            'verifying' => Application::where('status', 'verifying')->count(),
            'approved'  => Application::where('status', 'approved')->count(),
            'rejected'  => Application::where('status', 'rejected')->count(),
            'completed' => Application::where('status', 'completed')->count(),
            'warga'     => User::count(),
        ];

        $recentApplications = Application::with(['user', 'letterType'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $chartData = Application::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Lengkapi hari yang tidak ada datanya dengan 0
        $dates  = [];
        $totals = [];
        for ($i = 6; $i >= 0; $i--) {
            $date     = now()->subDays($i)->format('Y-m-d');
            $label    = now()->subDays($i)->locale('id')->isoFormat('D MMM');
            $found    = $chartData->firstWhere('date', $date);
            $dates[]  = $label;
            $totals[] = $found ? $found->total : 0;
        }

        // ── Jenis surat paling sering diajukan (top 5) ───
        $popularLetters = LetterType::withCount('applications')
            ->orderBy('applications_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'admin',
            'stats',
            'recentApplications',
            'dates',
            'totals',
            'popularLetters'
        ));
    }
}