@extends('layout')

@section('content')
<div class="container-fluid p-0">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center mb-4">
        {{-- Tombol Kembali ke Detail Ibu --}}
        <a href="{{ route('pasien.show', $patient->id) }}" class="btn btn-light rounded-circle border shadow-sm me-3" 
           style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0">Tambah Data Anak</h4>
            <span class="text-muted small">Ibu: <strong>{{ $patient->nama }}</strong> (NIK: {{ $patient->nik }})</span>
        </div>
    </div>

    {{-- CARD FORM --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">

            <form action="{{ route('anak.store') }}" method="POST" autocomplete="off">
                @csrf
                {{-- ID Pasien (Hidden) --}}
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                <div class="mb-4 pb-2 border-bottom">
                    <h6 class="fw-bold text-success text-uppercase mb-0">
                        <i class="bi bi-emoji-smile me-2"></i>Identitas Anak
                    </h6>
                </div>

                <div class="row g-4 mb-4">
                    {{-- Nama Anak --}}
                    <div class="col-12">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Nama Lengkap Anak</label>
                        <input type="text" name="nama" class="form-control form-control-lg bg-light-subtle border-0" 
                               placeholder="Masukkan nama anak..." required>
                    </div>

                    {{-- Tgl Lahir --}}
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control form-control-lg bg-light-subtle border-0" required>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select form-select-lg bg-light-subtle border-0" required>
                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>

                {{-- Data Kelahiran (Opsional) --}}
                <div class="p-4 bg-light rounded-4 mb-5">
                    <h6 class="fw-bold text-dark mb-3 small text-uppercase">Data Kelahiran (Opsional)</h6>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Berat Lahir (kg)</label>
                            <div class="input-group">
                                <input type="number" step="0.1" name="berat_lahir" class="form-control border-0 bg-white" placeholder="0.0">
                                <span class="input-group-text border-0 bg-white text-muted">kg</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Tinggi Lahir (cm)</label>
                            <div class="input-group">
                                <input type="number" step="0.1" name="tinggi_lahir" class="form-control border-0 bg-white" placeholder="0.0">
                                <span class="input-group-text border-0 bg-white text-muted">cm</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm rounded-pill">
                        <i class="bi bi-save me-2"></i>Simpan Data Anak
                    </button>
                    <a href="{{ route('pasien.show', $patient->id) }}" class="btn btn-light px-4 py-2 rounded-pill text-muted">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.25); /* Fokus warna hijau (Success) */
        border: 1px solid #198754 !important;
    }
</style>
@endsection