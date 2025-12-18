@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card-custom mt-4 p-4">
            <h3 class="text-center mb-3">Login</h3>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="/login" autocomplete="off">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           required
                           autocomplete="off">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           required
                           autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Login
                </button>
            </form>

            <p class="text-center mt-3">
                Belum punya akun? <a href="/register">Register</a>
            </p>
        </div>

    </div>
</div>
@endsection
