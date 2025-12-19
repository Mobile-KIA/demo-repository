@extends('layout')

@section('content')
    <div class="container-fluid p-4">

        {{-- HEADER & SEARCH --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
            <div>
                <h3 class="fw-bold text-dark mb-1">Data Tumbuh Kembang</h3>
                <p class="text-secondary mb-0">Total {{ count($children) }} anak terdaftar dalam sistem.</p>
            </div>

            {{-- Search Bar --}}
            <div class="input-group shadow-sm border-0 rounded-pill overflow-hidden" style="max-width: 300px;">
                <span class="input-group-text bg-white border-0 ps-3">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" id="searchAnak" class="form-control border-0 py-2" placeholder="Cari nama anak...">
            </div>
        </div>

        {{-- GRID DAFTAR ANAK --}}
        <div class="row g-4" id="childList">
            @forelse($children as $child)
                <div class="col-md-6 col-xl-4 search-item">
                    <div class="card h-100 border-0 shadow-sm rounded-4 hover-shadow transition-all">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start">

                                {{-- Avatar --}}
                                <div class="flex-shrink-0">
                                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px;">
                                        <i class="bi bi-emoji-smile fs-2"></i>
                                    </div>
                                </div>

                                {{-- Info Utama --}}
                                <div class="ms-3 flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="fw-bold text-dark mb-1 name-target" style="font-size: 1.1rem;">
                                            {{ $child->nama }}
                                        </h6>

                                        {{-- Badge Gender --}}
                                        @if($child->jenis_kelamin == 'L')
                                            <span
                                                class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill"
                                                style="font-size: 0.7rem;">
                                                <i class="bi bi-gender-male"></i> L
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill"
                                                style="font-size: 0.7rem;">
                                                <i class="bi bi-gender-female"></i> P
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-muted small mb-3">
                                        <i class="bi bi-cake2 me-1"></i> {{ $child->usia }}
                                    </div>

                                    {{-- Info Ibu (Context) --}}
                                    <div class="d-flex align-items-center p-2 bg-light rounded-3">
                                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center border shadow-sm me-2"
                                            style="width: 30px; height: 30px;">
                                            <span class="fw-bold text-primary"
                                                style="font-size: 0.7rem;">{{ substr($child->patient->nama ?? '?', 0, 1) }}</span>
                                        </div>
                                        <div class="lh-1">
                                            <small class="text-muted d-block"
                                                style="font-size: 0.65rem; text-transform: uppercase;">Nama Ibu</small>
                                            <span class="fw-semibold text-dark small">{{ $child->patient->nama ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-light-subtle my-3">

                            {{-- Footer Card --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-secondary">
                                    <i class="bi bi-calendar3 me-1"></i> Lahir: {{ $child->tgl_lahir->format('d M Y') }}
                                </small>
                                <a href="{{ route('anak.show', $child->id) }}"
                                    class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold">
                                    Detail & Grafik
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                            <i class="bi bi-emoji-neutral text-secondary opacity-50" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="text-secondary fw-bold">Belum ada data anak.</h5>
                        <p class="text-muted">Data anak akan muncul setelah ditambahkan melalui menu Detail Pasien.</p>
                        <a href="{{ route('pasien.index') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                            Ke Daftar Pasien Ibu
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- SCRIPT PENCARIAN CLIENT-SIDE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchAnak');
            const items = document.querySelectorAll('.search-item');

            searchInput.addEventListener('keyup', function (e) {
                const term = e.target.value.toLowerCase();

                items.forEach(function (item) {
                    const name = item.querySelector('.name-target').textContent.toLowerCase();
                    if (name.indexOf(term) != -1) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0.1) !important;
        }

        .transition-all {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .form-control:focus {
            box-shadow: none;
        }
    </style>
@endsection