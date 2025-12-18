@extends('layout')

@section('content')
    <div class="container py-3">

        {{-- 1. HEADER & TOMBOL KEMBALI --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('pasien.index') }}" class="btn btn-light border rounded-3 px-3">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>

            <div class="d-flex gap-2">
                <a href="{{ route('pasien.edit', $patient->id) }}" class="btn btn-warning text-white rounded-3">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>

                {{-- Form Hapus --}}
                <form action="{{ route('pasien.destroy', $patient->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus pasien ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger rounded-3">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- 2. KARTU PROFIL PASIEN (Simpel) --}}
        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-center gap-4">

                    {{-- Avatar Inisial --}}
                    <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                        {{ substr($patient->nama, 0, 1) }}
                    </div>

                    {{-- Info Utama --}}
                    <div class="text-center text-md-start flex-grow-1">
                        <h3 class="fw-bold mb-1">{{ $patient->nama }}</h3>
                        <div class="text-muted mb-2">NIK: {{ $patient->nik }}</div>

                        <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-3 mt-3">
                            <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                                <i class="bi bi-calendar3 me-1"></i> {{ $patient->umur }} Tahun
                            </span>
                            <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                                <i class="bi bi-whatsapp me-1"></i> {{ $patient->no_telp }}
                            </span>
                            <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                                <i class="bi bi-geo-alt me-1"></i> {{ $patient->alamat }}
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Tambah Pemeriksaan Besar --}}
                    <a href="{{ route('kehamilan.create', $patient->id) }}"
                        class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Periksa
                    </a>
                </div>
            </div>
        </div>

        {{-- 3. DAFTAR RIWAYAT PEMERIKSAAN --}}
        <h5 class="fw-bold mb-3 border-start border-4 border-primary ps-3">Riwayat Kehamilan</h5>

        <div class="row g-3">
            @forelse ($patient->kehamilans as $p)
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-4">
                            <div class="row align-items-center">

                                {{-- Kolom 1: Tanggal & Minggu --}}
                                <div class="col-md-3 mb-3 mb-md-0 border-end-md">
                                    <h5 class="fw-bold text-primary mb-0">Minggu ke-{{ $p->usia_kehamilan }}</h5>
                                    <small class="text-muted">
                                        {{ $p->created_at->format('d M Y, H:i') }} WIB
                                    </small>
                                </div>

                                {{-- Kolom 2: Data Fisik --}}
                                <div class="col-md-5 mb-3 mb-md-0">
                                    <div class="d-flex justify-content-around text-center">
                                        <div>
                                            <div class="small text-muted">Berat</div>
                                            <div class="fw-bold">{{ $p->berat_badan }} kg</div>
                                        </div>
                                        <div class="vr opacity-25"></div>
                                        <div>
                                            <div class="small text-muted">Tinggi</div>
                                            <div class="fw-bold">{{ $p->tinggi_badan }} cm</div>
                                        </div>
                                        <div class="vr opacity-25"></div>
                                        <div>
                                            <div class="small text-muted">Tensi</div>
                                            <div class="fw-bold text-danger">{{ $p->tekanan_darah }}</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Kolom 3: Keluhan & Aksi --}}
                                <div class="col-md-4">
                                    <div class="bg-light rounded p-2 mb-2">
                                        <small class="text-muted d-block fw-bold">Keluhan:</small>
                                        <span class="small text-dark">{{ $p->keluhan ?? '-' }}</span>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('kehamilan.edit', $p->id) }}"
                                            class="btn btn-sm btn-link text-decoration-none">
                                            Edit Data
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 bg-light rounded-3 text-muted">
                        <i class="bi bi-clipboard-x fs-1 mb-2"></i>
                        <p>Belum ada data pemeriksaan.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    {{-- CSS KHUSUS UNTUK RESPONSIVE BORDER --}}
    <style>
        /* Garis pemisah hanya muncul di layar besar (Desktop) */
        @media (min-width: 768px) {
            .border-end-md {
                border-right: 1px solid #dee2e6;
            }
        }
    </style>
@endsection