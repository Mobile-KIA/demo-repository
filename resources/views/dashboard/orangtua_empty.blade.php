@extends('layout')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5 text-center">

                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-exclamation-circle fs-2"></i>
                        </div>

                        <h4 class="fw-bold mb-2">Data Belum Lengkap</h4>
                        <p class="text-muted mb-4">
                            Untuk dapat memantau kehamilan dan data anak,<br>
                            silakan lengkapi data ibu terlebih dahulu.
                        </p>

                        <a href="{{ route('profile.edit') }}" class="btn btn-primary px-4">
                            Lengkapi Data Sekarang
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
