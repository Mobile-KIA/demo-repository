@extends('layout')

@section('content')
    <div class="container mt-4">

        <h4 class="fw-bold">Tambah Data Kehamilan</h4>
        <p>Pasien: <b>{{ $patient->nama }}</b></p>

        <form action="{{ route('kehamilan.store') }}" method="POST">
            @csrf

            <input type="hidden" name="patient_id" value="{{ $patient->id }}">

            <div class="mb-3">
                <label>Usia Kehamilan (minggu)</label>
                <input type="number" name="usia_kehamilan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Berat Badan (kg)</label>
                <input type="number" step="0.1" name="berat_badan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tinggi Badan (cm)</label>
                <input type="number" name="tinggi_badan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tekanan Darah</label>
                <input type="text" name="tekanan_darah" class="form-control" placeholder="120/80" required>
            </div>

            <div class="mb-3">
                <label>Keluhan</label>
                <textarea name="keluhan" class="form-control"></textarea>
            </div>

            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('dashboard.tenaga_medis') }}" class="btn btn-secondary">
                Batal
            </a>
        </form>

    </div>
@endsection
