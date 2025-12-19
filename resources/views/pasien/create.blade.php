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

                        {{-- CEK ERROR --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pasien.store') }}" ...></form>

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

                                {{-- === TAMBAHAN BARU: INPUT EMAIL === --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Email (Untuk Akun Login)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="contoh: ibu@gmail.com" required>
                                    </div>
                                    <div class="form-text text-primary">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Email ini akan digunakan Orang Tua untuk login. Password default adalah
                                        <strong>NIK</strong>.
                                    </div>
                                </div>

                                {{-- GANTI BAGIAN INPUT UMUR DENGAN INI --}}
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i
                                                class="bi bi-calendar-event"></i></span>
                                        {{-- Name harus 'tgl_lahir' agar sesuai dengan validasi controller --}}
                                        <input type="date" name="tgl_lahir" class="form-control" required>
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