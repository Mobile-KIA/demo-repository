@extends('layout')

@section('content')
    <div class="container-fluid p-0">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Edit Data Pemeriksaan</h3>
                <p class="text-body-secondary mb-0">
                    Perbarui hasil pemeriksaan kehamilan.
                </p>
            </div>
            {{-- Tombol Kembali mengarah ke Detail Pasien --}}
            <a href="{{ route('pasien.show', $pregnancy->patient_id) }}" class="btn btn-light border shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="row">
            {{-- Card dibuat Lebar Penuh (col-12) --}}
            <div class="col-12">

                {{-- ALERT INFO PASIEN (Konteks Data) --}}
                <div
                    class="alert alert-warning border-0 d-flex align-items-center mb-4 shadow-sm text-dark bg-warning bg-opacity-10">
                    <div class="bg-white text-warning rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                        style="width: 48px; height: 48px;">
                        <i class="bi bi-pencil-square fs-4"></i>
                    </div>
                    <div>
                        <small class="text-uppercase fw-bold opacity-75">Mengedit Data Pasien</small>
                        <h5 class="fw-bold mb-0">{{ $pregnancy->patient->nama ?? 'Pasien' }}</h5>
                    </div>
                    <div class="ms-auto text-end d-none d-sm-block">
                        <small class="text-uppercase fw-bold opacity-75">NIK</small>
                        <div class="fw-bold">{{ $pregnancy->patient->nik ?? '-' }}</div>
                    </div>
                </div>

                {{-- CARD FORM --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <form action="{{ route('kehamilan.update', $pregnancy->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT') {{-- WAJIB: Mengubah method menjadi PUT untuk update --}}

                            <h6 class="text-uppercase text-body-secondary small fw-bold mb-4">
                                <i class="bi bi-clipboard2-pulse me-2"></i>Perubahan Data Fisik
                            </h6>

                            <div class="row g-3">

                                {{-- USIA KEHAMILAN --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Usia Kehamilan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i
                                                class="bi bi-calendar-week"></i></span>
                                        <input type="number" name="usia_kehamilan" class="form-control"
                                            value="{{ old('usia_kehamilan', $pregnancy->usia_kehamilan) }}" required>
                                        <span class="input-group-text bg-light-subtle">Minggu</span>
                                    </div>
                                </div>

                                {{-- TEKANAN DARAH --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tekanan Darah</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i
                                                class="bi bi-heart-pulse text-danger"></i></span>
                                        <input type="text" name="tekanan_darah" class="form-control"
                                            value="{{ old('tekanan_darah', $pregnancy->tekanan_darah) }}" required>
                                        <span class="input-group-text bg-light-subtle">mmHg</span>
                                    </div>
                                </div>

                                {{-- BERAT BADAN --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Berat Badan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i
                                                class="bi bi-speedometer2"></i></span>
                                        <input type="number" step="0.1" name="berat_badan" class="form-control"
                                            value="{{ old('berat_badan', $pregnancy->berat_badan) }}" required>
                                        <span class="input-group-text bg-light-subtle">kg</span>
                                    </div>
                                </div>

                                {{-- TINGGI BADAN --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tinggi Badan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-rulers"></i></span>
                                        <input type="number" name="tinggi_badan" class="form-control"
                                            value="{{ old('tinggi_badan', $pregnancy->tinggi_badan) }}" required>
                                        <span class="input-group-text bg-light-subtle">cm</span>
                                    </div>
                                </div>

                                {{-- KELUHAN --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold mt-2">Keluhan / Catatan Tambahan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i
                                                class="bi bi-chat-square-text"></i></span>
                                        <textarea name="keluhan" class="form-control"
                                            rows="3">{{ old('keluhan', $pregnancy->keluhan) }}</textarea>
                                    </div>
                                </div>

                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="d-flex justify-content-end align-items-center mt-5 pt-3 border-top">
                                <a href="{{ route('pasien.show', $pregnancy->patient_id) }}"
                                    class="btn btn-link text-decoration-none text-secondary me-3">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection