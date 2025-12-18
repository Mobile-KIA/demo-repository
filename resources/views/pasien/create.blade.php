@extends('layout')

@section('content')
<div class="container">
    <h3>Tambah Pasien</h3>

    <form action="{{ route('pasien.store') }}" method="POST">
        @csrf

        <div class="mb-2">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Umur</label>
            <input type="number" name="umur" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>No Telp</label>
            <input type="text" name="no_telp" class="form-control" required>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('dashboard.tenaga_medis') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
