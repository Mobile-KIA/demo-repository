@extends('layout')

@section('content')
<div class="container-fluid p-0">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Tambah Data Kehamilan</h3>
            <p class="text-body-secondary mb-0">
                Input hasil pemeriksaan rutin terbaru.
            </p>
        </div>
        {{-- Sebaiknya kembali ke detail pasien, bukan index kehamilan global --}}
        <a href="{{ route('pasien.show', $patient->id) }}" class="btn btn-light border shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        {{-- UBAH DISINI: col-12 agar lebar penuh dengan style tetap sama --}}
        <div class="col-12"> 
            
            {{-- ALERT INFO PASIEN --}}
            <div class="alert alert-primary border-0 d-flex align-items-center mb-4 shadow-sm">
                <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" 
                     style="width: 48px; height: 48px;">
                    <i class="bi bi-person-pregnant fs-4"></i>
                </div>
                <div>
                    <small class="text-uppercase fw-bold opacity-75">Pasien</small>
                    <h5 class="fw-bold mb-0">{{ $patient->nama }}</h5>
                </div>
                <div class="ms-auto text-end d-none d-sm-block">
                    <small class="text-uppercase fw-bold opacity-75">NIK</small>
                    <div class="fw-bold">{{ $patient->nik }}</div>
                </div>
            </div>

            {{-- CARD FORM --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    
                    <form action="{{ route('kehamilan.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                        <h6 class="text-uppercase text-body-secondary small fw-bold mb-4">
                            <i class="bi bi-clipboard2-pulse me-2"></i>Data Pemeriksaan Fisik
                        </h6>

                        <div class="row g-3">
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Usia Kehamilan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-subtle"><i class="bi bi-calendar-week"></i></span>
                                    <input type="number" name="usia_kehamilan" class="form-control" placeholder="Contoh: 12" required>
                                    <span class="input-group-text bg-light-subtle">Minggu</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tekanan Darah</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-subtle"><i class="bi bi-heart-pulse text-danger"></i></span>
                                    <input type="text" name="tekanan_darah" class="form-control" placeholder="120/80" required>
                                    <span class="input-group-text bg-light-subtle">mmHg</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Berat Badan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-subtle"><i class="bi bi-speedometer2"></i></span>
                                    <input type="number" step="0.1" name="berat_badan" class="form-control" placeholder="00.0" required>
                                    <span class="input-group-text bg-light-subtle">kg</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tinggi Badan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-subtle"><i class="bi bi-rulers"></i></span>
                                    <input type="number" name="tinggi_badan" class="form-control" placeholder="000" required>
                                    <span class="input-group-text bg-light-subtle">cm</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold mt-2">Keluhan / Catatan Tambahan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-subtle"><i class="bi bi-chat-square-text"></i></span>
                                    <textarea name="keluhan" class="form-control" rows="3" placeholder="Tulis keluhan pasien jika ada..."></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-5 pt-3 border-top">
                            {{-- Tombol Batal kembali ke detail pasien --}}
                            <a href="{{ route('pasien.show', $patient->id) }}" class="btn btn-link text-decoration-none text-secondary me-3">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="bi bi-save me-2"></i>Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection