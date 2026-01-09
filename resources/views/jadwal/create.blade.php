@extends('layout')

@section('content')
    <div class="container-fluid p-0">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Buat Jadwal Kunjungan</h3>
                <p class="text-body-secondary mb-0">
                    Atur jadwal pemeriksaan atau imunisasi untuk pasien.
                </p>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-light border shadow-sm">
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

                        <form action="{{ route('jadwal.store') }}" method="POST" autocomplete="off">
                            @csrf

                            <h6 class="text-uppercase text-body-secondary small fw-bold mb-4">
                                <i class="bi bi-calendar-check me-2"></i>Detail Rencana
                            </h6>

                            <div class="row g-3">
                                
                                {{-- 1. PILIH PASIEN (Logika: Jika sudah ada pasien terpilih vs Belum) --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nama Pasien</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-person"></i></span>
                                        
                                        @if($selectedPatient)
                                            {{-- Jika dari halaman Detail Pasien (Read Only) --}}
                                            <input type="text" class="form-control bg-light" 
                                                   value="{{ $selectedPatient->nama }} (NIK: {{ $selectedPatient->nik }})" readonly>
                                            <input type="hidden" name="patient_id" value="{{ $selectedPatient->id }}">
                                        @else
                                            {{-- Jika dari Menu Utama (Dropdown) --}}
                                            <select name="patient_id" class="form-select" required>
                                                <option value="" selected disabled>-- Pilih Pasien --</option>
                                                @foreach($patients as $p)
                                                    <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->nik }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>

                                {{-- 2. TANGGAL KUNJUNGAN --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Rencana</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-calendar-event"></i></span>
                                        <input type="date" name="tanggal_kunjungan" class="form-control" 
                                               value="{{ \Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}" required>
                                    </div>
                                </div>

                                {{-- 3. JENIS KUNJUNGAN --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Jenis Kunjungan</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-clipboard-pulse"></i></span>
                                        <select name="jenis_kunjungan" class="form-select" required>
                                            <option value="Pemeriksaan Kehamilan">Pemeriksaan Kehamilan</option>
                                            <option value="Imunisasi Anak">Imunisasi Anak</option>
                                            <option value="Konsultasi Nifas">Konsultasi Nifas</option>
                                            <option value="Kunjungan Rutin">Kunjungan Rutin</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- 4. CATATAN --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Catatan Tambahan (Opsional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light-subtle"><i class="bi bi-chat-text"></i></span>
                                        <textarea name="catatan" class="form-control" rows="3" 
                                                  placeholder="Contoh: Ingatkan bawa buku KIA, Puasa sebelum periksa..."></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- FOOTER BUTTONS --}}
                            <div class="d-flex justify-content-end align-items-center mt-5 pt-3 border-top">
                                <a href="{{ url()->previous() }}"
                                    class="btn btn-link text-decoration-none text-secondary me-3">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                    <i class="bi bi-save me-2"></i>Simpan Jadwal
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection