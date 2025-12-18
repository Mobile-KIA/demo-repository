@extends('layout')

@section('content')
<div class="container-fluid">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-1">Pengaturan Akun</h4>
            <p class="text-muted small mb-0">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 position-relative overflow-hidden">
                <div class="card-body p-5">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                         style="width: 100px; height: 100px; font-size: 2.5rem;">
                        <span class="fw-bold">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    
                    <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3">
                        {{ $user->role }}
                    </span>
                    
                    <div class="text-muted small mb-4">{{ $user->email }}</div>

                    <hr class="opacity-10">

                    <div class="d-grid gap-2 text-start">
                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Statistik</small>
                        <div class="d-flex justify-content-between align-items-center p-2 rounded hover-bg-light">
                            <span><i class="bi bi-calendar-check me-2 text-secondary"></i> Bergabung</span>
                            <span class="fw-bold small">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100 bg-danger bg-opacity-10" style="height: 5px;"></div>
            </div>
        </div>

        <div class="col-md-8">
            
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-transparent border-0 py-3 px-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-person-gear me-2 text-danger"></i>Edit Biodata</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control bg-light border-0" value="{{ old('name', $user->name) }}">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Alamat Email</label>
                                <input type="email" name="email" class="form-control bg-light border-0" value="{{ old('email', $user->email) }}">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-dark px-4 rounded-pill">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 py-3 px-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-shield-lock me-2 text-danger"></i>Ganti Password</h6>
                </div>
                <div class="card-body px-4 pb-4">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label small text-muted">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control bg-light border-0">
                            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Password Baru</label>
                                <input type="password" name="password" class="form-control bg-light border-0">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small text-muted">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control bg-light border-0">
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-outline-danger px-4 rounded-pill">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection