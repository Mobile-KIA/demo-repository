@extends('layout')

@section('content')
    <div class="container-fluid p-0">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1">Riwayat Kehamilan</h3>
                <p class="text-body-secondary mb-0">
                    Data pemeriksaan rutin untuk pasien <strong>{{ $patient->nama }}</strong>.
                </p>
            </div>

            <div class="d-flex gap-2">
                {{-- Tombol Kembali --}}
                <a href="{{ route('pasien.index') }}" class="btn btn-light border shadow-sm">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>

                {{-- Tombol Tambah Data Kehamilan --}}
                <a href="{{ route('kehamilan.create', $patient->id) }}" class="btn btn-primary shadow-sm rounded-pill px-4">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Pemeriksaan
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4 bg-primary bg-opacity-10">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                        style="width: 48px; height: 48px; font-weight: bold; font-size: 1.2rem;">
                        {{ substr($patient->nama, 0, 1) }}
                    </div>
                    <div>
                        <h6 class="fw-bold text-primary mb-0">{{ $patient->nama }}</h6>
                        <small class="text-secondary">NIK: {{ $patient->nik }} | Usia: {{ $patient->umur }} Th</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light-subtle text-uppercase text-secondary small">
                            <tr>
                                <th class="px-4 py-3 border-0">Usia Kehamilan</th>
                                <th class="py-3 border-0">Fisik (BB / TB)</th>
                                <th class="py-3 border-0">Tekanan Darah</th>
                                <th class="py-3 border-0">Keluhan</th>
                                <th class="px-4 py-3 border-0 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($patient->kehamilans as $k)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                                                <i class="bi bi-calendar-week fs-5"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-heading">Minggu ke-{{ $k->usia_kehamilan }}</div>
                                                <div class="small text-body-secondary">
                                                    {{ $k->created_at ? $k->created_at->format('d M Y') : '-' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex flex-column small text-muted">
                                            <span><i class="bi bi-speedometer2 me-2" style="width:16px"></i>
                                                {{ $k->berat_badan }} kg</span>
                                            <span><i class="bi bi-rulers me-2" style="width:16px"></i> {{ $k->tinggi_badan }}
                                                cm</span>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2">
                                            {{ $k->tekanan_darah }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-secondary">
                                        @if($k->keluhan)
                                            {{ Str::limit($k->keluhan, 50) }}
                                        @else
                                            <span class="text-muted small fst-italic">- Tidak ada keluhan -</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('kehamilan.edit', $k->id) }}"
                                            class="btn btn-sm btn-light border text-warning shadow-sm" data-bs-toggle="tooltip"
                                            title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="bg-light rounded-circle p-3 mb-3">
                                                <i class="bi bi-clipboard2-pulse text-secondary fs-1"></i>
                                            </div>
                                            <h6 class="fw-bold text-secondary">Belum ada riwayat pemeriksaan</h6>
                                            <p class="small text-muted mb-3">Silakan tambahkan data pemeriksaan pertama.</p>
                                            <a href="{{ route('kehamilan.create', $patient->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                Tambah Pemeriksaan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection