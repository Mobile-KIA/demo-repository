@extends('layout')

@section('content')
    <div class="container py-3">

        {{-- NAVIGASI ATAS --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            {{-- Tombol Kembali ke Ibu --}}
            <a href="{{ route('pasien.show', $child->patient_id) }}" class="btn btn-light border rounded-pill px-3 shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Ibu
            </a>

            {{-- Tombol Aksi Halaman --}}
            <div class="d-flex gap-2">
                {{-- Tombol Hapus Anak --}}
                <form action="{{ route('anak.destroy', $child->id) }}" method="POST"
                    onsubmit="return confirm('⚠️ PERINGATAN: \n\nMenghapus data anak ini akan menghapus seluruh RIWAYAT PERTUMBUHANNYA juga. \n\nApakah Anda yakin ingin melanjutkan?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-white border shadow-sm rounded-pill text-danger hover-danger"
                        title="Hapus Data Anak">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- BAGIAN 1: PROFIL ANAK --}}
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
                            @if ($child->jenis_kelamin == 'L')
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

        {{-- BAGIAN 2: RIWAYAT PERTUMBUHAN --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-secondary text-uppercase small mb-0">
                    <i class="bi bi-graph-up me-2 text-primary"></i>Riwayat Pertumbuhan
                </h6>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" data-bs-toggle="modal"
                    data-bs-target="#modalCatatTumbuh">
                    <i class="bi bi-plus-lg me-1"></i> Catat
                </button>
            </div>

            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    @forelse($child->growths as $growth)
                        {{-- Inner Card (Sub-Card) --}}
                        <div
                            class="card border border-light-subtle shadow-none rounded-3 hover-bg-light transition-all">
                            <div class="card-body p-3">
                                <div class="row align-items-center gy-3">
                                    {{-- Info Waktu --}}
                                    <div class="col-md-3 border-end-md">
                                        <h6 class="fw-bold text-dark mb-0">
                                            {{ \Carbon\Carbon::parse($child->tgl_lahir)->diff($growth->tanggal)->format('%y Th %m Bln') }}
                                        </h6>
                                        <small class="text-muted" style="font-size: 0.8rem;">
                                            {{ $growth->tanggal->format('d M Y') }}
                                        </small>
                                    </div>

                                    {{-- Info Fisik --}}
                                    <div class="col-md-5 border-end-md">
                                        <div class="d-flex gap-4">
                                            <div>
                                                <span class="d-block text-muted" style="font-size: 0.7rem;">BERAT</span>
                                                <span class="fw-bold text-success">{{ $growth->berat_badan }}</span> <small>kg</small>
                                            </div>
                                            <div>
                                                <span class="d-block text-muted" style="font-size: 0.7rem;">TINGGI</span>
                                                <span class="fw-bold text-info">{{ $growth->tinggi_badan }}</span> <small>cm</small>
                                            </div>
                                            @if($growth->lingkar_kepala)
                                                <div>
                                                    <span class="d-block text-muted" style="font-size: 0.7rem;">LINGKAR KEPALA</span>
                                                    <span class="fw-bold">{{ $growth->lingkar_kepala }}</span> <small>cm</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Catatan --}}
                                    <div class="col-md-4">
                                        <div class="text-truncate">
                                            <span class="d-block text-muted" style="font-size: 0.7rem;">CATATAN</span>
                                            <span class="small text-dark text-truncate d-block" style="max-width: 100%;">
                                                {{ $growth->catatan ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-4 border border-dashed rounded-3 bg-light-subtle">
                                <p class="text-muted small mb-0">Belum ada data pengukuran.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- BAGIAN 3: RIWAYAT IMUNISASI --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-secondary text-uppercase small mb-0">
                    <i class="bi bi-shield-check me-2 text-info"></i>Riwayat Imunisasi
                </h6>
                <button type="button" class="btn btn-sm btn-info text-white rounded-pill px-3 fw-bold shadow-sm"
                    data-bs-toggle="modal" data-bs-target="#modalImunisasi">
                    <i class="bi bi-plus-lg me-1"></i> Catat
                </button>
            </div>

            <div class="card-body p-4">
                <div class="d-flex flex-column gap-3">
                    @forelse($child->immunizations as $immune)
                        {{-- Inner Card (Sub-Card) --}}
                        <div class="card border border-light-subtle shadow-none rounded-3 hover-bg-light transition-all">
                            <div class="card-body p-3">
                                <div class="row align-items-center gy-3">
                                    {{-- Info Waktu --}}
                                    <div class="col-md-3 border-end-md">
                                        <h6 class="fw-bold text-dark mb-0">{{ $immune->tanggal_imunisasi->format('d M Y') }}</h6>
                                        <small class="text-muted" style="font-size: 0.8rem;">Tanggal Suntik</small>
                                    </div>

                                    {{-- Info Vaksin --}}
                                    <div class="col-md-5 border-end-md">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info-subtle px-3 py-2 rounded-pill">
                                                {{ $immune->jenis_vaksin }}
                                            </span>
                                            @if($immune->nomor_batch)
                                                <div class="font-monospace small text-muted">
                                                    Batch: {{ $immune->nomor_batch }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Aksi --}}
                                    <div class="col-md-4 d-flex justify-content-between align-items-center">
                                         <div class="me-3 text-truncate">
                                            <span class="d-block text-muted" style="font-size: 0.7rem;">CATATAN/KIPI</span>
                                            <span class="small text-dark text-truncate d-block" style="max-width: 150px;">
                                                {{ $immune->catatan ?? '-' }}
                                            </span>
                                        </div>

                                        <form action="{{ route('imunisasi.destroy', $immune->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus data imunisasi ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-light btn-sm rounded-circle border text-danger hover-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-4 border border-dashed rounded-3 bg-light-subtle">
                                <p class="text-muted small mb-0">Belum ada data imunisasi.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- MODAL CATAT PERTUMBUHAN --}}
    <div class="modal fade" id="modalCatatTumbuh" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Catat Pertumbuhan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('anak.growth.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="child_id" value="{{ $child->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Tanggal Pengukuran</label>
                            <input type="date" name="tanggal" class="form-control bg-light-subtle border-0" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-secondary">Berat Badan (kg)</label>
                                <input type="number" step="0.01" name="berat_badan" class="form-control bg-light-subtle border-0" placeholder="0.00" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-secondary">Tinggi Badan (cm)</label>
                                <input type="number" step="0.1" name="tinggi_badan" class="form-control bg-light-subtle border-0" placeholder="0.0" required>
                            </div>
                        </div>
                         <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Lingkar Kepala (cm) <span class="fw-normal text-muted">(Opsional)</span></label>
                            <input type="number" step="0.1" name="lingkar_kepala" class="form-control bg-light-subtle border-0" placeholder="0.0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Catatan Medis</label>
                            <textarea name="catatan" class="form-control bg-light-subtle border-0" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL CATAT IMUNISASI --}}
    <div class="modal fade" id="modalImunisasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Catat Imunisasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('imunisasi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="child_id" value="{{ $child->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Tanggal Imunisasi</label>
                            <input type="date" name="tanggal_imunisasi" class="form-control bg-light-subtle border-0" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Jenis Vaksin</label>
                            <select name="jenis_vaksin" class="form-select bg-light-subtle border-0" required>
                                <option value="" disabled selected>Pilih Vaksin...</option>
                                <option value="Hepatitis B0">Hepatitis B0 (< 24 Jam)</option>
                                <option value="BCG">BCG (Polio 1)</option>
                                <option value="DPT-HB-Hib 1">DPT-HB-Hib 1 (Polio 2)</option>
                                <option value="DPT-HB-Hib 2">DPT-HB-Hib 2 (Polio 3)</option>
                                <option value="DPT-HB-Hib 3">DPT-HB-Hib 3 (Polio 4)</option>
                                <option value="IPV">IPV (Polio Suntik)</option>
                                <option value="Campak Rubella">Campak Rubella (MR)</option>
                                <option value="Booster DPT">Booster DPT (Lanjutan)</option>
                                <option value="Booster MR">Booster MR (Lanjutan)</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Nomor Batch</label>
                            <input type="text" name="nomor_batch" class="form-control bg-light-subtle border-0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Catatan / KIPI</label>
                            <textarea name="catatan" class="form-control bg-light-subtle border-0" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-info text-white rounded-pill px-4 shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Menggunakan style yang SAMA PERSIS dengan Halaman Pasien */
        .hover-bg-light:hover {
            background-color: #f8f9fa;
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

        .form-control:focus, .form-select:focus {
            background-color: #fff !important;
            border: 1px solid var(--bs-primary) !important;
            box-shadow: none;
        }

        @media (min-width: 768px) {
            .border-end-md {
                border-right: 1px solid #e9ecef;
            }
        }
    </style>
@endsection