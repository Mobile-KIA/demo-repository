@extends('layout')

@section('content')
    {{-- Container Fluid agar Penuh Layar --}}
    <div class="container-fluid px-4 py-5">

        {{-- HEADER TENGAH --}}
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark display-6">Menu Rekam Medis</h2>
            <p class="text-muted">Akses data kesehatan ibu dan anak dalam satu pintu.</p>
        </div>

        <div class="row g-4 justify-content-center">

            {{-- 1. IBU HAMIL (Warna Merah/Pink) --}}
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('pasien.index') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center hover-card p-4">
                        <div class="card-body">
                            <div>
                                <img src="https://img.icons8.com/color/96/pregnant.png" alt="Ibu Hamil"
                                    class="img-fluid" style="height: 120px; width: auto;">
                            </div>

                            <h4 class="fw-bold text-dark mb-2">Ibu Hamil</h4>
                            <p class="text-muted small mb-0">
                                Data pemeriksaan kehamilan (ANC), riwayat nifas, dan kondisi ibu.
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- 2. TUMBUH KEMBANG (Warna Hijau) --}}
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('anak.index') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center hover-card p-4">
                        <div class="card-body">
                            {{-- LOGO BESAR --}}
                            <div class="icon-circle bg-success bg-opacity-10 text-success mx-auto mb-4">
                                <i class="bi bi-graph-up-arrow display-4"></i>
                            </div>

                            <h4 class="fw-bold text-dark mb-2">Tumbuh Kembang</h4>
                            <p class="text-muted small mb-0">
                                Grafik pertumbuhan anak, pengukuran berat & tinggi badan berkala.
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- 3. IMUNISASI (Warna Biru) --}}
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('anak.index') }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm rounded-4 text-center hover-card p-4">
                        <div class="card-body">
                            {{-- LOGO BESAR --}}
                            <div class="icon-circle bg-info bg-opacity-10 text-info mx-auto mb-4">
                                <i class="bi bi-shield-check display-4"></i>
                            </div>

                            <h4 class="fw-bold text-dark mb-2">Imunisasi</h4>
                            <p class="text-muted small mb-0">
                                Jadwal vaksinasi, riwayat suntik, dan jenis vaksin anak.
                            </p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <style>
        /* Styling Lingkaran Logo */
        .icon-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        /* Efek Hover Halus */
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-10px);
            /* Naik sedikit saat dihover */
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1) !important;
        }

        /* Saat dihover, icon membesar sedikit */
        .hover-card:hover .icon-circle {
            transform: scale(1.1);
        }
    </style>
@endsection