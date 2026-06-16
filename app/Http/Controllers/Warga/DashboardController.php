<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard warga
     */
    public function index()
    {
        $user = Auth::guard('web')->user();

        // Ambil statistik pengajuan warga ini
        $stats = [
            'total'      => Application::where('user_id', $user->id)->count(),
            'pending'    => Application::where('user_id', $user->id)
                                       ->where('status', 'pending')->count(),
            'verifying'  => Application::where('user_id', $user->id)
                                       ->where('status', 'verifying')->count(),
            'approved'   => Application::where('user_id', $user->id)
                                       ->where('status', 'approved')->count(),
            'rejected'   => Application::where('user_id', $user->id)
                                       ->where('status', 'rejected')->count(),
            'completed'  => Application::where('user_id', $user->id)
                                       ->where('status', 'completed')->count(),
        ];

        // Ambil 5 pengajuan terbaru
        $recentApplications = Application::where('user_id', $user->id)
            ->with('letterType')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('warga.dashboard', compact('user', 'stats', 'recentApplications'));
    }
}