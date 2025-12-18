@extends('layout')

@section('content')
    <div class="container mt-4">

        <h4 class="fw-bold">Riwayat Kehamilan</h4>
        <p>Pasien: <b>{{ $patient->nama }}</b></p>

        @if ($patient->kehamilans->count() == 0)
            <p class="text-muted">Belum ada data kehamilan</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Usia</th>
                        <th>BB</th>
                        <th>TB</th>
                        <th>Tekanan Darah</th>
                        <th>Keluhan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($patient->kehamilans as $k)
                        <tr>
                            <td>{{ $k->usia_kehamilan }}</td>
                            <td>{{ $k->berat_badan }}</td>
                            <td>{{ $k->tinggi_badan }}</td>
                            <td>{{ $k->tekanan_darah }}</td>
                            <td>{{ $k->keluhan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('kehamilan.edit', $k->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        @endif

        <a href="{{ route('dashboard.tenaga_medis') }}" class="btn btn-secondary">
            Kembali
        </a>

    </div>
@endsection
