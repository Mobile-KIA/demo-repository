@extends('layout')

@section('content')
    <div class="container py-3">

        {{-- NAVIGASI ATAS (Breadcrumb style) --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('pasien.index') }}" class="btn btn-light border rounded-pill px-3 shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
            </a>

            {{-- Tombol Aksi Halaman --}}
            <div class="d-flex gap-2">
                <a href="{{ route('pasien.edit', $patient->id) }}"
                    class="btn btn-white border shadow-sm rounded-pill text-muted hover-primary">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('pasien.destroy', $patient->id) }}" method="POST"
                    onsubmit="return confirm('Hapus data pasien ini?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-white border shadow-sm rounded-pill text-danger hover-danger">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- BAGIAN 1: PROFIL IBU --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            {{-- Konsisten Header --}}
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold text-secondary text-uppercase small mb-0">
                    <i class="bi bi-person-vcard me-2 text-primary"></i>Informasi Pasien
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                    {{-- Avatar --}}
                    <div class="position-relative">
                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                            {{ substr($patient->nama, 0, 1) }}
                        </div>
                    </div>

                    {{-- Detail --}}
                    <div class="text-center text-md-start flex-grow-1">
                        <h3 class="fw-bold mb-1">{{ $patient->nama }}</h3>
                        <p class="text-muted mb-3">{{ $patient->nik }}</p>

                        <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                            <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                <i class="bi bi-cake2 me-1 text-secondary"></i> {{ $patient->umur }} Tahun
                            </span>
                            <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                <i class="bi bi-whatsapp me-1 text-success"></i> {{ $patient->no_telp }}
                            </span>
                            <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                <i class="bi bi-geo-alt me-1 text-danger"></i> {{ $patient->alamat }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN 2: DATA ANAK --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            {{-- Konsisten Header --}}
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-secondary text-uppercase small mb-0">
                    <i class="bi bi-emoji-smile me-2 text-success"></i>Data Anak
                </h6>
                <a href="{{ route('anak.create', $patient->id) }}" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </a>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">
                    @forelse($patient->children as $child)
                        <div class="col-md-6 col-xl-4">
                            {{-- Inner Card (Sub-Card) --}}
                            <div
                                class="card border border-light-subtle shadow-none rounded-3 h-100 hover-bg-light transition-all">
                                <div class="card-body p-3 d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 me-3"
                                        style="width: 48px; height: 48px;">
                                        <i class="bi bi-emoji-smile fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-0 text-dark">{{ $child->nama }}</h6>
                                        <small class="text-muted d-block" style="font-size: 0.85rem;">
                                            {{ $child->usia }} •
                                            <span class="{{ $child->jenis_kelamin == 'L' ? 'text-primary' : 'text-danger' }}">
                                                {{ $child->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </span>
                                        </small>
                                    </div>
                                    <a href="{{ route('anak.show', $child->id) }}"
                                        class="btn btn-light btn-sm rounded-circle border">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-4 border border-dashed rounded-3 bg-light-subtle">
                                <p class="text-muted small mb-0">Belum ada data anak.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- BAGIAN 3: RIWAYAT KEHAMILAN --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            {{-- Konsisten Header --}}
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-secondary text-uppercase small mb-0">
                    <i class="bi bi-journal-medical me-2 text-info"></i>Riwayat Kehamilan
                </h6>
                <a href="{{ route('kehamilan.create', $patient->id) }}"
                    class="btn btn-sm btn-primary rounded-pill px-3 fw-bold">
                    <i class="bi bi-plus-lg me-1"></i> Tambah
                </a>
            </div>

            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    @forelse ($patient->kehamilans as $p)
                        {{-- Inner Card (Sub-Card) --}}
                        <div class="card border border-light-subtle shadow-none rounded-3 hover-bg-light transition-all">
                            <div class="card-body p-3">
                                <div class="row align-items-center gy-3">
                                    {{-- Info Waktu --}}
                                    <div class="col-md-3 border-end-md">
                                        <h6 class="fw-bold text-primary mb-0">Minggu ke-{{ $p->usia_kehamilan }}</h6>
                                        <small class="text-muted" style="font-size: 0.8rem;">
                                            {{ $p->created_at->format('d M Y') }}
                                        </small>
                                    </div>

                                    {{-- Info Fisik (Grid Mini) --}}
                                    <div class="col-md-5 border-end-md">
                                        <div class="d-flex gap-4">
                                            <div>
                                                <span class="d-block text-muted" style="font-size: 0.7rem;">BERAT</span>
                                                <span class="fw-bold">{{ $p->berat_badan }}</span> <small>kg</small>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted" style="font-size: 0.7rem;">TINGGI</span>
                                                <span class="fw-bold">{{ $p->tinggi_badan }}</span> <small>cm</small>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted" style="font-size: 0.7rem;">TENSI</span>
                                                <span class="fw-bold text-danger">{{ $p->tekanan_darah }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Catatan & Edit --}}
                                    <div class="col-md-4 d-flex justify-content-between align-items-center">
                                        <div class="me-3 text-truncate">
                                            <span class="d-block text-muted" style="font-size: 0.7rem;">CATATAN</span>
                                            <span class="small text-dark text-truncate d-block" style="max-width: 180px;">
                                                {{ $p->keluhan ?? '-' }}
                                            </span>
                                        </div>
                                        <a href="{{ route('kehamilan.edit', $p->id) }}"
                                            class="btn btn-light btn-sm rounded-circle border">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-4 border border-dashed rounded-3 bg-light-subtle">
                                <p class="text-muted small mb-0">Belum ada riwayat pemeriksaan.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <style>
        /* Styling Tambahan untuk Hover Effect Halus */
        .hover-bg-light:hover {
            background-color: #f8f9fa;
            /* Bootstrap Gray-100 */
            border-color: #dee2e6 !important;
        }

        .hover-primary:hover {
            background-color: var(--bs-primary);
            color: white !important;
            border-color: var(--bs-primary) !important;
        }

        .hover-danger:hover {
            background-color: var(--bs-danger);
            color: white !important;
            border-color: var(--bs-danger) !important;
        }

        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        .border-dashed {
            border-style: dashed !important;
        }

        @media (min-width: 768px) {
            .border-end-md {
                border-right: 1px solid #e9ecef;
            }
        }
    </style>
@endsection