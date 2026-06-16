@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')

{{-- Stat Cards ──────────────────────────────────── --}}
<div class="row g-3 mb-4">

    <div class="col-xl-2 col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#6366f1,#4f46e5);">
            <div class="stat-number">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Pengajuan</div>
            <i class="bi bi-file-earmark-text stat-icon"></i>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
            <div class="stat-number">{{ $stats['pending'] }}</div>
            <div class="stat-label">Menunggu</div>
            <i class="bi bi-clock stat-icon"></i>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#06b6d4,#0891b2);">
            <div class="stat-number">{{ $stats['verifying'] }}</div>
            <div class="stat-label">Diverifikasi</div>
            <i class="bi bi-search stat-icon"></i>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#3b82f6,#2563eb);">
            <div class="stat-number">{{ $stats['approved'] }}</div>
            <div class="stat-label">Disetujui</div>
            <i class="bi bi-check-circle stat-icon"></i>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#ef4444,#dc2626);">
            <div class="stat-number">{{ $stats['rejected'] }}</div>
            <div class="stat-label">Ditolak</div>
            <i class="bi bi-x-circle stat-icon"></i>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="stat-card" style="background:linear-gradient(135deg,#22c55e,#16a34a);">
            <div class="stat-number">{{ $stats['completed'] }}</div>
            <div class="stat-label">Selesai</div>
            <i class="bi bi-check-all stat-icon"></i>
        </div>
    </div>

</div>

{{-- Grafik + Jenis Surat Populer ────────────────── --}}
<div class="row g-3 mb-4">

    {{-- Grafik 7 hari terakhir --}}
    <div class="col-xl-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="bi bi-bar-chart-line me-2 text-primary"></i>
                    Pengajuan 7 Hari Terakhir
                </span>
            </div>
            <div class="card-body">
                <canvas id="chartPengajuan" height="100"></canvas>
            </div>
        </div>
    </div>

    {{-- Jenis surat populer --}}
    <div class="col-xl-4">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-trophy me-2 text-warning"></i>
                Surat Paling Sering Diajukan
            </div>
            <div class="card-body p-0">
                @forelse($popularLetters as $index => $letter)
                    <div class="d-flex align-items-center justify-content-between
                                px-3 py-2
                                {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill
                                {{ $index === 0 ? 'bg-warning text-dark' :
                                   ($index === 1 ? 'bg-secondary' : 'bg-light text-dark') }}"
                                  style="width:24px;height:24px;display:flex;
                                         align-items:center;justify-content:center;">
                                {{ $index + 1 }}
                            </span>
                            <span class="small fw-medium">{{ $letter->name }}</span>
                        </div>
                        <span class="badge bg-primary">
                            {{ $letter->applications_count }} pengajuan
                        </span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4 small">
                        Belum ada data
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- Pengajuan Terbaru ────────────────────────────── --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-clock-history me-2"></i>Pengajuan Terbaru
        </span>
        <a href="/admin/applications/index"
           class="btn btn-sm btn-outline-primary">
            Lihat Semua
        </a>
    </div>
    <div class="card-body p-0">
        @if($recentApplications->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox" style="font-size:2.5rem;"></i>
                <p class="mt-2 small">Belum ada pengajuan masuk</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No. Pengajuan</th>
                            <th>Nama Warga</th>
                            <th>NIK</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentApplications as $app)
                        <tr>
                            <td>
                                <span class="fw-semibold text-primary">
                                    {{ $app->application_number }}
                                </span>
                            </td>
                            <td>{{ $app->user->name }}</td>
                            <td>
                                <span class="text-muted small">
                                    {{ $app->user->nik }}
                                </span>
                            </td>
                            <td>{{ $app->letterType->name }}</td>
                            <td>
                                <span class="small text-muted">
                                    {{ $app->created_at->format('d/m/Y H:i') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $app->status_color }}">
                                    {{ $app->status_label }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.applications.show', $app->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('chartPengajuan').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($dates),
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: @json($totals),
                backgroundColor: 'rgba(99, 102, 241, 0.7)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.parsed.y} pengajuan`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection