@extends('layout')

@section('content')
<div class="container-fluid p-0">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Edit Data Pasien</h3>
            <p class="text-body-secondary mb-0">
                Perbarui informasi data diri pasien <strong>{{ $patient->nama }}</strong>.
            </p>
        </div>
        <a href="{{ route('pasien.index') }}" class="btn btn-light border shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        {{-- UBAH DISINI: col-12 agar lebar penuh --}}
        <div class="col-12"> 
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    {{-- Global Error Alert --}}
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 d-flex align-items-center mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                            <div>
                                <strong>Terjadi Kesalahan!</strong><br>
                                <small>Silakan periksa kembali inputan Anda.</small>
                            </div>
                        </div>
                    @endif
                    
                    <form action="{{ route('pasien.update', $patient->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT') 

                        <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </div>
                            <h6 class="text-uppercase text-body-secondary fw-bold mb-0">Formulir Perubahan Data</h6>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-subtle"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama" 
                                           class="form-control @error('nama') is-invalid @enderror" 
                                           value="{{ old('nama', $patient->nama) }}" required>
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">NIK</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-subtle"><i class="bi bi-card-heading"></i></span>
                                    <input type="number" name="nik" 
                                           class="form-control @error('nik') is-invalid @enderror" 
                                           value="{{ old('nik', $patient->nik) }}" required>
                                    @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Umur</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-subtle"><i class="bi bi-calendar3"></i></span>
                                    <input type="number" name="umur" 
                                           class="form-control @error('umur') is-invalid @enderror" 
                                           value="{{ old('umur', $patient->umur) }}" required>
                                    <span class="input-group-text bg-light-subtle">Tahun</span>
                                    @error('umur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Nomor Telepon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-subtle"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" name="no_telp" 
                                           class="form-control @error('no_telp') is-invalid @enderror" 
                                           value="{{ old('no_telp', $patient->no_telp) }}" required>
                                    @error('no_telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Alamat Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light-subtle"><i class="bi bi-geo-alt"></i></span>
                                    <textarea name="alamat" rows="3" 
                                              class="form-control @error('alamat') is-invalid @enderror" 
                                              required>{{ old('alamat', $patient->alamat) }}</textarea>
                                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-5 pt-3 border-top">
                            <a href="{{ route('pasien.index') }}" class="btn btn-link text-decoration-none text-secondary me-3">
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