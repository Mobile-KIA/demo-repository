@extends('layout')

@section('content')
    <div class="container py-3">

        {{-- HEADER NAVIGASI --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            {{-- Kembali ke Ibunya --}}
            <a href="{{ route('pasien.show', $child->patient_id) }}"
                class="btn btn-light border rounded-pill px-3 shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Ibu
            </a>

            <div class="d-flex gap-2">
                {{-- TOMBOL HAPUS (Update Bagian Ini) --}}
                <form action="{{ route('anak.destroy', $child->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('⚠️ PERINGATAN: \n\nMenghapus data anak ini akan menghapus seluruh RIWAYAT PERTUMBUHANNYA juga. \n\nApakah Anda yakin ingin melanjutkan?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-white border shadow-sm rounded-pill text-danger hover-danger"
                        title="Hapus Data Anak">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- 1. KARTU PROFIL ANAK --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold text-secondary text-uppercase small mb-0">
                    <i class="bi bi-person-badge me-2 text-success"></i>Identitas Anak
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                    {{-- Avatar --}}
                    <div class="position-relative">
                        <div class="bg-success bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-emoji-smile fs-1"></i>
                        </div>
                    </div>

                    {{-- Detail --}}
                    <div class="text-center text-md-start flex-grow-1">
                        <h3 class="fw-bold mb-1">{{ $child->nama }}</h3>
                        <p class="text-muted mb-3">
                            Lahir: {{ $child->tgl_lahir->format('d M Y') }}
                        </p>

                        <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                            <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                <i class="bi bi-cake2 me-1 text-secondary"></i> {{ $child->usia }}
                            </span>
                            @if($child->jenis_kelamin == 'L')
                                <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                    <i class="bi bi-gender-male me-1 text-primary"></i> Laki-laki
                                </span>
                            @else
                                <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                    <i class="bi bi-gender-female me-1 text-danger"></i> Perempuan
                                </span>
                            @endif
                            <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                <i class="bi bi-person-standing-dress me-1 text-success"></i> Ibu:
                                {{ $child->patient->nama }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. RIWAYAT PERTUMBUHAN --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            {{-- Header dengan Tombol Tambah (Modal) --}}
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-secondary text-uppercase small mb-0">
                    <i class="bi bi-graph-up me-2 text-primary"></i>Riwayat Pertumbuhan
                </h6>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" data-bs-toggle="modal"
                    data-bs-target="#modalCatatTumbuh">
                    <i class="bi bi-plus-lg me-1"></i> Catat Pengukuran
                </button>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light text-secondary small text-uppercase">
                            <tr>
                                <th class="ps-3 py-3 border-0 rounded-start">Tanggal</th>
                                <th class="border-0">Usia Saat Ukur</th>
                                <th class="border-0 text-center">Berat (kg)</th>
                                <th class="border-0 text-center">Tinggi (cm)</th>
                                <th class="border-0 rounded-end">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($child->growths as $growth)
                                <tr>
                                    <td class="ps-3 fw-bold text-secondary">
                                        {{ $growth->tanggal->format('d M Y') }}
                                    </td>
                                    <td class="small text-muted">
                                        {{-- Hitung usia saat tanggal pengukuran --}}
                                        {{ \Carbon\Carbon::parse($child->tgl_lahir)->diff($growth->tanggal)->format('%y th %m bln') }}
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-3">
                                            {{ $growth->berat_badan }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-3">
                                            {{ $growth->tinggi_badan }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $growth->catatan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-clipboard2-data fs-1 opacity-25 d-block mb-2"></i>
                                        Belum ada data pengukuran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL CATAT PENGUKURAN --}}
    <div class="modal fade" id="modalCatatTumbuh" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Catat Pertumbuhan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('anak.growth.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="child_id" value="{{ $child->id }}">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Tanggal Pengukuran</label>
                            <input type="date" name="tanggal" class="form-control bg-light-subtle border-0"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-secondary">Berat Badan (kg)</label>
                                <input type="number" step="0.01" name="berat_badan"
                                    class="form-control bg-light-subtle border-0" placeholder="0.00" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-secondary">Tinggi Badan (cm)</label>
                                <input type="number" step="0.1" name="tinggi_badan"
                                    class="form-control bg-light-subtle border-0" placeholder="0.0" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Lingkar Kepala (cm) <span
                                    class="fw-normal text-muted">(Opsional)</span></label>
                            <input type="number" step="0.1" name="lingkar_kepala"
                                class="form-control bg-light-subtle border-0" placeholder="0.0">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Catatan Medis</label>
                            <textarea name="catatan" class="form-control bg-light-subtle border-0" rows="2"
                                placeholder="Contoh: Anak sehat, nafsu makan baik..."></textarea>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .hover-danger:hover {
            background-color: var(--bs-danger);
            color: white !important;
            border-color: var(--bs-danger) !important;
        }

        .form-control:focus {
            background-color: #fff !important;
            border: 1px solid var(--bs-primary) !important;
            box-shadow: none;
        }
    </style>
@endsection