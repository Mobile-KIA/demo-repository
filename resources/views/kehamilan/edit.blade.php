@extends('layout')

@section('content')
    <div class="container mt-4">

        <h4>Edit Data Kehamilan</h4>

        <form action="{{ route('kehamilan.update', $pregnancy->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Usia Kehamilan (minggu)</label>
                <input type="number" name="usia_kehamilan" value="{{ $pregnancy->usia_kehamilan }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label>Berat Badan (kg)</label>
                <input type="number" step="0.1" name="berat_badan" value="{{ $pregnancy->berat_badan }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tinggi Badan (cm)</label>
                <input type="number" name="tinggi_badan" value="{{ $pregnancy->tinggi_badan }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label>Tekanan Darah</label>
                <input type="text" name="tekanan_darah" value="{{ $pregnancy->tekanan_darah }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label>Keluhan</label>
                <textarea name="keluhan" class="form-control">{{ $pregnancy->keluhan }}</textarea>
            </div>

            <button class="btn btn-success">Update</button>
            <a href="{{ route('kehamilan.index', $pregnancy->patient_id) }}" class="btn btn-secondary">Batal</a>
        </form>

    </div>
@endsection
