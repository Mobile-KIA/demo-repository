@extends('layout')

@section('content')
    <div class="container py-5">

        {{-- INFO JIKA DATA BELUM ADA --}}
        @if (!$patient)
            <div class="alert alert-info rounded-4 mb-4">
                <i class="bi bi-info-circle me-2"></i>
                Data kesehatan akan muncul setelah diperiksa oleh tenaga medis.
            </div>
        @endif

        {{-- 1. HERO SECTION --}}
        <div class="card border-0 shadow-sm rounded-4 mb-5 overflow-hidden">
            <div class="card-body p-0">
                <div class="row g-0">

                    {{-- SAPAAN --}}
                    <div class="col-lg-8 p-4 p-md-5 d-flex align-items-center">
                        <div class="me-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 64px; height: 64px;">
                                <i class="bi bi-heart-fill fs-3"></i>
                            </div>
                        </div>
                        <div>
                            <h6 class="text-uppercase text-muted fw-bold small ls-1 mb-1">
                                Dashboard Bunda
                            </h6>

                            <h2 class="fw-bold text-dark mb-1">
                                Halo,
                                {{ $patient ? explode(' ', $patient->nama)[0] : Auth::user()->name }}!
                            </h2>

                            <p class="text-secondary mb-0 small">
                                Pantau kesehatan keluarga dengan mudah.
                            </p>
                        </div>
                    </div>

                    {{-- JADWAL --}}
                    <div
                        class="col-lg-4 bg-primary bg-opacity-10 p-4 p-md-5 d-flex flex-column justify-content-center border-start border-light">
                        <span class="text-uppercase text-primary fw-bold small ls-1 mb-2">
                            <i class="bi bi-calendar-event me-1"></i> Jadwal Kontrol
                        </span>

                        <h3 class="fw-bold text-dark mb-0">
                            {{ $nextVisit ? $nextVisit->format('d M Y') : '-' }}
                        </h3>

                        <small class="text-muted mt-1">
                            {{ $visitType ?? '-' }}
                        </small>
                    </div>

                </div>
            </div>
        </div>

        {{-- 2. MAIN CONTENT --}}
        <div class="row g-4 align-items-stretch">

            {{-- STATUS KEHAMILAN --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-bottom border-light pt-4 px-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold text-dark mb-0">Status Kehamilan</h6>

                            @if ($patient && $patient->kehamilans->count())
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                    Aktif
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        @if ($patient && $patient->kehamilans->count())
                            @php $lastPreg = $patient->kehamilans->last(); @endphp

                            <div class="text-center py-2">
                                <span class="display-3 fw-bold text-danger">
                                    {{ $lastPreg->usia_kehamilan }}
                                </span>
                                <span class="fs-5 text-secondary fw-medium d-block mt-n2">
                                    Minggu
                                </span>
                            </div>

                            <div class="row mt-4 g-0 bg-light rounded-3 border text-center">
                                <div class="col-4 py-3 border-end">
                                    <small class="text-muted d-block mb-1">BERAT</small>
                                    <span class="fw-bold">{{ $lastPreg->berat_badan }} kg</span>
                                </div>
                                <div class="col-4 py-3 border-end">
                                    <small class="text-muted d-block mb-1">TINGGI</small>
                                    <span class="fw-bold">{{ $lastPreg->tinggi_badan }} cm</span>
                                </div>
                                <div class="col-4 py-3">
                                    <small class="text-muted d-block mb-1">TENSI</small>
                                    <span class="fw-bold">{{ $lastPreg->tekanan_darah }}</span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-clipboard-x fs-3 mb-3"></i>
                                <p class="small mb-0">Belum ada data kehamilan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- DATA ANAK --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-bottom border-light pt-4 px-4 pb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0">Data Anak</h6>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                {{ $patient ? $patient->children->count() : 0 }} Anak
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @if ($patient && $patient->children->count())
                            @foreach ($patient->children as $child)
                                <div class="p-3 mb-2 border rounded-3">
                                    <strong>{{ $child->nama }}</strong><br>
                                    <small class="text-muted">
                                        {{ $child->usia }} | {{ $child->jenis_kelamin }}
                                    </small>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-3 mb-3"></i>
                                <p class="small mb-0">Belum ada data anak.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
