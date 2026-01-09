@extends('layout')

@section('content')
    <div class="container-fluid p-0">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Tambah Data Anak</h3>
                <p class="text-body-secondary mb-0">
                    Daftarkan anak baru untuk pasien <strong>{{ $patient->nama }}</strong>.
                </p>
            </div>
            <a href="{{ route('pasien.show', $patient->id) }}" class="btn btn-light border shadow-sm">
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

                        <form action="{{ route('anak.store') }}" method="POST" autocomplete="off">
                            @csrf
                            <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                            <h6 class="text-uppercase text-body-secondary small fw-bold mb-4">
                                <i class="bi bi-emoji-smile me-2"></i>Identitas Anak
                            </h6>

                            <div class="row g-3">
                                
                                {{-- 1. NAMA ANAK --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nama Lengkap Anak</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-person"></i></span>
                                        <input type="text" name="nama" class="form-control" 
                                               placeholder="Contoh: Budi Santoso" required>
                                    </div>
                                </div>

                                {{-- 2. TANGGAL LAHIR --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-calendar-event"></i></span>
                                        <input type="date" name="tgl_lahir" class="form-control" required>
                                    </div>
                                </div>

                                {{-- 3. JENIS KELAMIN --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Jenis Kelamin</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle">
                                            <i class="bi bi-gender-ambiguous"></i>
                                        </span>
                                        <select name="jenis_kelamin" class="form-select" required>
                                            <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="border-light-subtle my-2">
                                    <h6 class="text-uppercase text-body-secondary small fw-bold mt-2 mb-3">
                                        <i class="bi bi-rulers me-2"></i>Data Kelahiran (Opsional)
                                    </h6>
                                </div>

                                {{-- 4. BERAT LAHIR --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Berat Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-speedometer2"></i></span>
                                        <input type="number" step="0.01" name="berat_lahir" class="form-control" placeholder="0.0">
                                        <span class="input-group-text bg-light-subtle">kg</span>
                                    </div>
                                </div>

                                {{-- 5. TINGGI LAHIR --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tinggi Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-arrow-bar-up"></i></span>
                                        <input type="number" step="0.1" name="tinggi_lahir" class="form-control" placeholder="0.0">
                                        <span class="input-group-text bg-light-subtle">cm</span>
                                    </div>
                                </div>

                            </div>

                            {{-- FOOTER BUTTONS --}}
                            <div class="d-flex justify-content-end align-items-center mt-5 pt-3 border-top">
                                <a href="{{ route('pasien.show', $patient->id) }}"
                                    class="btn btn-link text-decoration-none text-secondary me-3">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-success px-4 shadow-sm">
                                    <i class="bi bi-save me-2"></i>Simpan Data Anak
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection