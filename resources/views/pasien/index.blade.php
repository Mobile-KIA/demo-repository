@extends('layout')

@section('content')
    <div class="container-fluid p-0">

        {{-- ALERT SUKSES (Muncul jika ada pesan dari controller) --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">

            <div class="w-100 w-md-auto">
                <h3 class="fw-bold mb-1">Daftar Pasien</h3>
                <p class="text-body-secondary mb-0">Total {{ count($patients) }} pasien</p>
            </div>

            <div class="d-flex w-100 w-md-auto gap-2">

                <div class="input-group shadow-sm bg-white rounded-3" style="min-width: 250px;">
                    <span class="input-group-text bg-transparent border-end-0 text-secondary pe-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0 ps-2"
                        placeholder="Cari nama pasien...">
                </div>

                <a href="{{ route('pasien.create') }}"
                    class="btn btn-primary rounded-3 px-4 d-flex align-items-center flex-shrink-0 shadow-sm">
                    <i class="bi bi-plus-lg me-2"></i>Baru
                </a>

            </div>
        </div>

        <div class="row g-3" id="patientList">
            @forelse($patients as $patient)
                <div class="col-12 col-md-6 col-xl-4 search-item">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-4 bg-primary bg-gradient text-white d-flex align-items-center justify-content-center fs-4 fw-bold shadow-sm"
                                            style="width: 56px; height: 56px;">
                                            {{ substr($patient->nama, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="fw-bold text-dark mb-1 name-target">{{ $patient->nama }}</h5>
                                        <div class="badge bg-light text-secondary border mb-2">
                                            <i class="bi bi-card-heading me-1"></i> {{ $patient->nik }}
                                        </div>
                                    </div>
                                </div>

                                {{-- DROPDOWN ACTION --}}
                                <div class="dropdown">
                                    <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                        {{-- DETAIL --}}
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('pasien.show', $patient->id) }}">
                                                <i class="bi bi-eye me-2 text-primary"></i> Detail
                                            </a>
                                        </li>
                                        
                                        {{-- EDIT --}}
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('pasien.edit', $patient->id) }}">
                                                <i class="bi bi-pencil me-2 text-warning"></i> Edit
                                            </a>
                                        </li>

                                        <li><hr class="dropdown-divider"></li>

                                        {{-- HAPUS (FORM DELETE) --}}
                                        <li>
                                            <form action="{{ route('pasien.destroy', $patient->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-2 text-danger" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data pasien {{ $patient->nama }}? Data tidak bisa dikembalikan.')">
                                                    <i class="bi bi-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                {{-- END DROPDOWN --}}
                                
                            </div>
                            <hr class="border-light-subtle my-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-body-secondary">Terdaftar:
                                    {{ $patient->created_at ? $patient->created_at->format('d M Y') : '-' }}</small>
                                <a href="{{ route('pasien.show', $patient->id) }}"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Lihat Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-people text-secondary opacity-25" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-secondary fw-bold">Belum ada data pasien</h5>
                    <p class="text-muted">Silakan tambahkan data pasien baru.</p>
                </div>
            @endforelse
        </div>

        <div id="noResult" class="text-center py-5 d-none">
            <h5 class="text-secondary fw-bold">Data tidak ditemukan</h5>
            <p class="text-muted">Coba kata kunci lain.</p>
        </div>

    </div>

    <style>
        .transition-all {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }
    </style>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('.search-item');
            let hasResult = false;

            items.forEach(function (item) {
                let name = item.querySelector('.name-target').textContent.toLowerCase();
                if (name.includes(filter)) {
                    item.style.display = '';
                    hasResult = true;
                } else {
                    item.style.display = 'none';
                }
            });

            let noResultMsg = document.getElementById('noResult');
            if (!hasResult) {
                noResultMsg.classList.remove('d-none');
            } else {
                noResultMsg.classList.add('d-none');
            }
        });
    </script>
@endsection