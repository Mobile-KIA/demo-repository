@extends('layout')

@section('content')
    <div class="container mt-4">

        <h3 class="fw-bold">Dashboard Tenaga Medis</h3>
        <p>Kelola data pasien dan kehamilan</p>

        <hr>

        <a href="{{ route('pasien.create') }}" class="btn btn-primary mb-3">
            + Tambah Pasien
        </a>

        @if ($patients->count() == 0)
            <p class="text-muted">Belum ada data pasien</p>
        @else
            <table class="table table-bordered">
                <thead class="table-success">
                    <tr>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>No Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $patient->nama }}</td>
                            <td>{{ $patient->nik }}</td>
                            <td>{{ $patient->no_telp }}</td>
                            <td>
                                <a href="{{ route('pasien.show', $patient->id) }}" class="btn btn-info btn-sm">
                                    Detail
                                </a>

                                <a href="{{ route('pasien.edit', $patient->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <a href="{{ route('kehamilan.index', $patient->id) }}" class="btn btn-success btn-sm">
                                    Riwayat Kehamilan
                                </a>

                                <a href="{{ route('kehamilan.create', $patient->id) }}" class="btn btn-primary btn-sm">
                                    + Tambah Data Kehamilan
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>
@endsection
