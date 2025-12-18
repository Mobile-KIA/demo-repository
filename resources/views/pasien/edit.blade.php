@extends('layout')

@section('content')
<div class="container mt-4">
    <h3>Edit Data Pasien</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pasien.update', $patient->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control"
                value="{{ old('nama', $patient->nama) }}" required>
        </div>

        <div class="mb-3">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control"
                value="{{ old('nik', $patient->nik) }}" required>
        </div>

        <div class="mb-3">
            <label>Umur</label>
            <input type="number" name="umur" class="form-control"
                value="{{ old('umur', $patient->umur) }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ old('alamat', $patient->alamat) }}</textarea>
        </div>

        <div class="mb-3">
            <label>No Telp</label>
            <input type="text" name="no_telp" class="form-control"
                value="{{ old('no_telp', $patient->no_telp) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Perubahan
        </button>

        <a href="{{ route('dashboard.tenaga_medis') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>
@endsection
