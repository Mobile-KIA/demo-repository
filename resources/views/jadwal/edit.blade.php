@extends('layout')

@section('content')
    <div class="container-fluid p-0">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Edit Jadwal Kunjungan</h3>
                <p class="text-body-secondary mb-0">
                    Perbarui data rencana pemeriksaan atau imunisasi.
                </p>
            </div>
            <a href="{{ route('pasien.show', $schedule->patient_id) }}" class="btn btn-light border shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        {{-- ERROR HANDLING --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('jadwal.update', $schedule->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <h6 class="text-uppercase text-body-secondary small fw-bold mb-4">
                                <i class="bi bi-pencil-square me-2"></i>Form Perubahan Data
                            </h6>

                            <div class="row g-3">

                                {{-- 1. INFO PASIEN (READ ONLY) --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nama Pasien</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control bg-light"
                                            value="{{ $schedule->patient->nama }} (NIK: {{ $schedule->patient->nik }})"
                                            readonly>
                                    </div>
                                    <div class="form-text text-muted">
                                        <i class="bi bi-info-circle me-1"></i> Data pasien tidak dapat diubah dari menu ini.
                                    </div>
                                </div>

                                {{-- 2. TANGGAL RENCANA --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Rencana</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-calendar-event"></i></span>
                                        <input type="date" name="tanggal_kunjungan" class="form-control"
                                            value="{{ $schedule->tanggal_kunjungan->format('Y-m-d') }}" required>
                                    </div>
                                </div>

                                {{-- 3. JENIS KUNJUNGAN --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Jenis Kunjungan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-clipboard-pulse"></i></span>
                                        <select name="jenis_kunjungan" class="form-select" required>
                                            <option value="Pemeriksaan Kehamilan" {{ $schedule->jenis_kunjungan == 'Pemeriksaan Kehamilan' ? 'selected' : '' }}>Pemeriksaan Kehamilan</option>
                                            <option value="Imunisasi Anak" {{ $schedule->jenis_kunjungan == 'Imunisasi Anak' ? 'selected' : '' }}>Imunisasi Anak</option>
                                            <option value="Konsultasi Nifas" {{ $schedule->jenis_kunjungan == 'Konsultasi Nifas' ? 'selected' : '' }}>Konsultasi Nifas</option>
                                            <option value="Kunjungan Rutin" {{ $schedule->jenis_kunjungan == 'Kunjungan Rutin' ? 'selected' : '' }}>Kunjungan Rutin</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- 4. CATATAN --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Catatan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-chat-text"></i></span>
                                        <textarea name="catatan" class="form-control" rows="3">{{ $schedule->catatan }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- FOOTER BUTTONS --}}
                            <div class="d-flex justify-content-end align-items-center mt-5 pt-3 border-top">
                                <a href="{{ route('pasien.show', $schedule->patient_id) }}"
                                    class="btn btn-link text-decoration-none text-secondary me-3">
                                    Batal
                                </a>
                                {{-- Menggunakan warna Warning (Kuning) untuk identitas Edit --}}
                                <button type="submit" class="btn btn-warning text-white px-4 shadow-sm fw-bold">
                                    <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection