@extends('layout')

@section('content')
<style>
    /* Styling Timeline Vertical */
    .timeline-wrapper {
        position: relative;
        padding-left: 20px;
    }
    .timeline-wrapper::before {
        content: '';
        position: absolute;
        top: 0; bottom: 0; left: 6px;
        width: 2px; background: #e9ecef; border-radius: 2px;
    }
    .timeline-card {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .timeline-dot {
        position: absolute;
        left: -21px; top: 15px;
        width: 14px; height: 14px;
        border-radius: 50%;
        background: var(--bs-primary);
        border: 3px solid #fff;
        box-shadow: 0 0 0 1px var(--bs-primary);
        z-index: 1;
    }
    .pregnancy-bar {
        height: 12px;
        background-color: #e9ecef;
        border-radius: 20px;
        overflow: hidden;
    }
    .icon-box-md {
        width: 56px; height: 56px;
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.75rem;
    }
</style>

<div class="container-fluid p-0">

    {{-- 1. HEADER & WELCOME --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Halo, Bunda {{ explode(' ', auth()->user()->name)[0] }}! 👋</h3>
            <p class="text-body-secondary mb-0">Pantau perkembangan Si Kecil hari ini.</p>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-white text-dark border shadow-sm px-3 py-2 rounded-pill">
                <i class="bi bi-calendar-event me-2 text-primary"></i>
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    {{-- ALERT JIKA BELUM ADA DATA --}}
    @if(!$patient || !$latestCheckup)
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4">
            <i class="bi bi-exclamation-circle-fill fs-4 me-3"></i>
            <div>
                <strong>Data belum tersedia.</strong>
                <div class="small">Silakan hubungi tenaga medis untuk melakukan pemeriksaan pertama Bunda.</div>
            </div>
        </div>
    @else
        
        {{-- 2. INFO UTAMA (PROGRESS KEHAMILAN) --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100 overflow-hidden">
                    <div class="card-body p-4 position-relative">
                        <i class="bi bi-heart-pulse position-absolute end-0 bottom-0 mb-n3 me-n3 text-danger opacity-10" style="font-size: 10rem;"></i>

                        <div class="d-flex flex-column flex-md-row align-items-center gap-4 position-relative z-1">
                            {{-- Lingkaran Minggu --}}
                            <div class="position-relative">
                                <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center shadow" 
                                     style="width: 120px; height: 120px;">
                                    <div class="text-center">
                                        <div class="small opacity-75 text-uppercase fw-bold" style="font-size: 0.7rem;">Minggu Ke</div>
                                        <div class="display-4 fw-bold lh-1">{{ $current_week }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Info Progress --}}
                            <div class="flex-grow-1 w-100">
                                <h4 class="fw-bold mb-1">Perkembangan Kehamilan</h4>
                                <p class="text-muted mb-3">Estimasi Lahir (HPL): <strong class="text-primary">{{ $hpl }}</strong></p>
                                
                                <div class="pregnancy-bar mb-2">
                                    <div class="bg-primary bg-gradient" style="width: {{ $progress_percent }}%; height: 100%;"></div>
                                </div>
                                <div class="d-flex justify-content-between small fw-bold text-secondary">
                                    <span>Trimester 1</span>
                                    <span>Trimester 2</span>
                                    <span>Trimester 3</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- JADWAL KUNJUNGAN BERIKUTNYA --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100 bg-primary bg-opacity-10">
                    <div class="card-body p-4 d-flex flex-column justify-content-center text-center">
                        <div class="mb-3">
                            <div class="bg-white text-primary rounded-circle d-inline-flex p-3 shadow-sm">
                                <i class="bi bi-calendar-check fs-1"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold text-primary">Kunjungan Berikutnya</h5>
                        @if($next_visit)
                            <h3 class="fw-bold mb-1">{{ $next_visit->translatedFormat('d M Y') }}</h3>
                            <p class="small text-muted mb-0">Estimasi jadwal periksa rutin bulan depan.</p>
                        @else
                            <p class="text-muted">Jadwal belum ditentukan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. DETAIL KESEHATAN TERAKHIR (CARD GRID) --}}
        <h5 class="fw-bold mb-3 px-1">Kondisi Terakhir Bunda</h5>
        <div class="row g-4 mb-4">
            {{-- Berat Badan --}}
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-3">
                        <div class="icon-box-md bg-warning bg-opacity-10 text-warning mx-auto mb-2">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <div class="small text-muted text-uppercase fw-bold">Berat Badan</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ $latestCheckup->berat_badan }} <small class="fs-6">kg</small></h4>
                    </div>
                </div>
            </div>
            
            {{-- Tinggi Badan --}}
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-3">
                        <div class="icon-box-md bg-info bg-opacity-10 text-info mx-auto mb-2">
                            <i class="bi bi-rulers"></i>
                        </div>
                        <div class="small text-muted text-uppercase fw-bold">Tinggi Badan</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ $latestCheckup->tinggi_badan }} <small class="fs-6">cm</small></h4>
                    </div>
                </div>
            </div>

            {{-- Tekanan Darah --}}
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-3">
                        <div class="icon-box-md bg-danger bg-opacity-10 text-danger mx-auto mb-2">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <div class="small text-muted text-uppercase fw-bold">Tensi</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ $latestCheckup->tekanan_darah }}</h4>
                    </div>
                </div>
            </div>

            {{-- Status/Catatan --}}
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-3">
                        <div class="icon-box-md bg-success bg-opacity-10 text-success mx-auto mb-2">
                            <i class="bi bi-file-medical"></i>
                        </div>
                        <div class="small text-muted text-uppercase fw-bold">Catatan</div>
                        <div class="fw-bold text-dark text-truncate" style="max-width: 100%;">
                            {{ $latestCheckup->keluhan ?? 'Sehat' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- 4. RIWAYAT PEMERIKSAAN (TIMELINE) --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0">Riwayat Pemeriksaan</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline-wrapper ps-2">
                            @foreach($history->take(3) as $log)
                                <div class="timeline-card pb-3">
                                    <div class="timeline-dot"></div>
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">Pemeriksaan Minggu ke-{{ $log->usia_kehamilan }}</h6>
                                            <div class="small text-muted">
                                                <i class="bi bi-calendar3 me-1"></i> {{ $log->created_at->format('d F Y') }}
                                            </div>
                                        </div>
                                        <span class="badge bg-light text-secondary border">Selesai</span>
                                    </div>
                                    @if($log->keluhan)
                                        <div class="mt-2 p-2 bg-light rounded small text-secondary">
                                            Catatan: {{ $log->keluhan }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            
                            @if($history->count() > 3)
                                <div class="text-center mt-3">
                                    <button class="btn btn-sm btn-link text-decoration-none">Lihat Semua Riwayat</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- 5. EDUKASI / ARTIKEL --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-danger bg-gradient text-white h-100 overflow-hidden">
                    <div class="card-body p-4 position-relative d-flex flex-column justify-content-center">
                        <i class="bi bi-book-half position-absolute bottom-0 end-0 mb-n4 me-n3 text-white opacity-25" 
                           style="font-size: 8rem; transform: rotate(-20deg);"></i>
                        
                        <h5 class="fw-bold mb-3 position-relative z-1">Buku KIA Digital</h5>
                        <p class="small opacity-90 mb-4 position-relative z-1">
                            Baca panduan lengkap kesehatan ibu dan anak, nutrisi penting, dan tanda bahaya kehamilan.
                        </p>
                        <div>
                            <button class="btn btn-light text-danger fw-bold shadow-sm rounded-pill px-4 position-relative z-1">
                                Baca Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>
@endsection