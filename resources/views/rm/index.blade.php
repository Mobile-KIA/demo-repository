@extends('layout')

@section('content')
    <div class="container-fluid p-4">

        {{-- HEADER SIMPEL --}}
        <div class="mb-5">
            <h3 class="fw-bold text-dark">Rekam Medis</h3>
            <p class="text-secondary">Pilih kategori layanan untuk melihat daftar pasien terkait.</p>
        </div>

        <div class="row g-4">

            {{-- 1. KEHAMILAN (Link ke Daftar IBU) --}}
            <div class="col-md-6 col-xl-4">
                {{-- UPDATE LINK DISINI: Ke pasien.index --}}
                <a href="{{ route('pasien.index') }}" class="text-decoration-none card-hover-effect">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4 d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div
                                    class="icon-shape bg-danger bg-opacity-10 text-danger rounded-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-pregnant fs-3"></i>
                                </div>
                                <div class="action-icon text-muted opacity-50">
                                    <i class="bi bi-arrow-right fs-4"></i>
                                </div>
                            </div>

                            <h5 class="fw-bold text-dark mb-2">Kehamilan</h5>
                            <p class="text-muted small mb-0">
                                Masuk ke daftar <strong>Ibu Hamil</strong> untuk pemeriksaan ANC dan riwayat kehamilan.
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- 2. TUMBUH KEMBANG (Link ke Daftar ANAK) --}}
            <div class="col-md-6 col-xl-4">
                {{-- UPDATE LINK DISINI: Ke anak.index --}}
                <a href="{{ route('anak.index') }}" class="text-decoration-none card-hover-effect">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4 d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div
                                    class="icon-shape bg-success bg-opacity-10 text-success rounded-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-flower1 fs-3"></i>
                                </div>
                                <div class="action-icon text-muted opacity-50">
                                    <i class="bi bi-arrow-right fs-4"></i>
                                </div>
                            </div>

                            <h5 class="fw-bold text-dark mb-2">Tumbuh Kembang</h5>
                            <p class="text-muted small mb-0">
                                Masuk ke daftar <strong>Data Anak</strong> untuk memantau grafik pertumbuhan (BB/TB).
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- 3. IMUNISASI (Link ke Daftar ANAK juga) --}}
            <div class="col-md-6 col-xl-4">
                {{-- UPDATE LINK DISINI: Ke anak.index (Karena imunisasi data anak) --}}
                <a href="{{ route('anak.index') }}" class="text-decoration-none card-hover-effect">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-4 d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div
                                    class="icon-shape bg-info bg-opacity-10 text-info rounded-3 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-shield-check fs-3"></i>
                                </div>
                                <div class="action-icon text-muted opacity-50">
                                    <i class="bi bi-arrow-right fs-4"></i>
                                </div>
                            </div>

                            <h5 class="fw-bold text-dark mb-2">Imunisasi</h5>
                            <p class="text-muted small mb-0">
                                Masuk ke daftar <strong>Data Anak</strong> untuk mencatat jadwal dan riwayat vaksinasi.
                            </p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <style>
        /* Ukuran Ikon Kotak */
        .icon-shape {
            width: 56px;
            height: 56px;
            transition: all 0.3s ease;
        }

        /* Animasi Hover Card */
        .card-hover-effect .card {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .card-hover-effect:hover .card {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, 0.08) !important;
        }

        /* Animasi Panah Bergeser saat Hover */
        .card-hover-effect:hover .action-icon {
            color: var(--bs-primary) !important;
            opacity: 1 !important;
            transform: translateX(5px);
            transition: transform 0.3s ease;
        }
    </style>
@endsection