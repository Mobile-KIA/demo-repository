@extends('layout')

@section('content')
    <style>
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); }
        .icon-box {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }
        [data-bs-theme="dark"] .bg-light-subtle { background-color: rgba(255, 255, 255, 0.05) !important; }
    </style>

    <div class="container-fluid p-0">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Dashboard Medis</h3>
                <p class="text-body-secondary mb-0">Selamat datang, {{ auth()->user()->name }}</p>
            </div>
            <div>
                <a href="{{ route('pasien.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Pasien Baru
                </a>
            </div>
        </div>

        {{-- CARDS STATISTIK --}}
        <div class="row g-4 mb-4">
            {{-- Total Pasien --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-body-secondary fw-semibold small text-uppercase">Total Pasien</span>
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                        <h2 class="mb-0 fw-bold">{{ $stats['total_pasien'] }}</h2>
                        <span class="small text-body-secondary">Terdaftar dalam sistem</span>
                    </div>
                </div>
            </div>

            {{-- Ibu Hamil Aktif --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-body-secondary fw-semibold small text-uppercase">Data Kehamilan</span>
                            <div class="icon-box bg-info bg-opacity-10 text-info">
                                <i class="bi bi-person-standing-dress"></i>
                            </div>
                        </div>
                        <h2 class="mb-0 fw-bold">{{ $stats['ibu_hamil'] }}</h2>
                        <span class="small text-body-secondary">Rekam medis aktif</span>
                    </div>
                </div>
            </div>

            {{-- Resiko Tinggi --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-danger fw-bold small text-uppercase">Resiko Tinggi</span>
                            <div class="icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                        </div>
                        <h2 class="mb-0 fw-bold text-danger">{{ $stats['resiko_tinggi'] }}</h2>
                        <span class="small text-danger fw-medium">Tensi > 140 mmHg</span>
                    </div>
                </div>
            </div>

            {{-- Kunjungan Hari Ini --}}
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100 stat-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-body-secondary fw-semibold small text-uppercase">Kunjungan Hari Ini</span>
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="bi bi-calendar-check-fill"></i>
                            </div>
                        </div>
                        <h2 class="mb-0 fw-bold">{{ $stats['kunjungan_hari_ini'] }}</h2>
                        <span class="small text-body-secondary">Pasien diperiksa hari ini</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- TABEL PASIEN TERBARU --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Pemeriksaan Terbaru</h5>
                        <a href="{{ route('pasien.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light-subtle text-uppercase text-secondary small">
                                    <tr>
                                        <th class="px-4 border-0">Nama Pasien</th>
                                        <th class="border-0">Usia Kehamilan</th>
                                        <th class="border-0">Status Tensi</th>
                                        <th class="border-0 text-end px-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPregnancies as $pregnancy)
                                        @php
                                            // Logic Sederhana cek Resiko
                                            $tensi = explode('/', $pregnancy->tekanan_darah);
                                            $isHighRisk = isset($tensi[0]) && (int)$tensi[0] >= 140;
                                        @endphp
                                        <tr>
                                            <td class="px-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                        style="width: 40px; height: 40px">
                                                        {{ substr($pregnancy->patient->nama, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $pregnancy->patient->nama }}</div>
                                                        <div class="small text-body-secondary">{{ $pregnancy->patient->nik }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $pregnancy->usia_kehamilan }} Minggu</td>
                                            <td>
                                                @if($isHighRisk)
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">
                                                        Resiko Tinggi ({{ $pregnancy->tekanan_darah }})
                                                    </span>
                                                @else
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                                        Normal ({{ $pregnancy->tekanan_darah }})
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-end px-4">
                                                <a href="{{ route('pasien.show', $pregnancy->patient_id) }}" class="btn btn-sm btn-light border">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Belum ada data pemeriksaan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SIDEBAR KANAN (JADWAL / AKTIVITAS) --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="mb-0 fw-bold">Aktivitas Hari Ini</h5>
                    </div>
                    <div class="card-body px-4 pb-4">
                        @forelse($todaysActivity as $activity)
                            <div class="d-flex align-items-start mb-3 pb-3 border-bottom border-light-subtle">
                                <div class="me-3 text-center" style="min-width: 50px;">
                                    <div class="fw-bold text-primary">{{ $activity->updated_at->format('H:i') }}</div>
                                    <div class="small text-body-secondary">WIB</div>
                                </div>
                                <div>
                                    <div class="fw-bold">Pemeriksaan Rutin</div>
                                    <div class="small text-body-secondary">Ny. {{ $activity->patient->nama }}</div>
                                    <small class="text-muted d-block">Tensi: {{ $activity->tekanan_darah }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-calendar-x fs-1 opacity-25"></i>
                                <p class="small mt-2">Belum ada kunjungan hari ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Banner Info --}}
                <div class="card border-0 shadow-sm bg-primary text-white">
                    <div class="card-body p-4 position-relative overflow-hidden">
                        <i class="bi bi-info-circle position-absolute top-0 end-0 mt-n2 me-n2 text-white opacity-25"
                            style="font-size: 8rem;"></i>

                        <h5 class="fw-bold position-relative z-1">Edukasi</h5>
                        <p class="small opacity-75 position-relative z-1">Pastikan selalu mengecek tekanan darah dan kadar
                            Hemoglobin pada trimester ketiga.</p>
                        <button class="btn btn-sm btn-light text-primary fw-bold position-relative z-1">Baca Edukasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection