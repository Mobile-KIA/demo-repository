@extends('layout')

@section('content')
    <div class="container-fluid p-0">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Tambah Pasien Baru</h3>
                <p class="text-body-secondary mb-0">
                    Isi formulir di bawah untuk mendaftarkan pasien ke dalam sistem.
                </p>
            </div>
            <a href="{{ route('pasien.index') }}" class="btn btn-light border shadow-sm">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            {{-- UBAH DISINI: Ganti col-lg-10 col-xl-8 menjadi col-12 agar lebar --}}
            <div class="col-12">

                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <form action="{{ route('pasien.store') }}" method="POST" autocomplete="off">
                            @csrf

                            <h6 class="text-uppercase text-body-secondary small fw-bold mb-4">
                                <i class="bi bi-person-vcard me-2"></i>Informasi Pribadi
                            </h6>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-person"></i></span>
                                        <input type="text" name="nama" class="form-control"
                                            placeholder="Contoh: Siti Aminah" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">NIK (Nomor Induk Kependudukan)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i
                                                class="bi bi-card-heading"></i></span>
                                        <input type="number" name="nik" class="form-control" placeholder="16 digit NIK"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Umur</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i
                                                class="bi bi-calendar3"></i></span>
                                        <input type="number" name="umur" class="form-control" placeholder="0" required>
                                        <span class="input-group-text bg-light-subtle">Tahun</span>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Nomor Telepon / WhatsApp</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-whatsapp"></i></span>
                                        <input type="text" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx"
                                            required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Alamat Lengkap</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-geo-alt"></i></span>
                                        <textarea name="alamat" class="form-control" rows="3"
                                            placeholder="Nama jalan, RT/RW, Desa, Kecamatan..." required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center mt-5 pt-3 border-top">
                                <a href="{{ route('pasien.index') }}"
                                    class="btn btn-link text-decoration-none text-secondary me-3">
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