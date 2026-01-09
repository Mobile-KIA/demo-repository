@extends('layout')

@section('content')
    <div class="container-fluid p-0">

        {{-- Header & Search & Filter --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <div class="w-100 w-md-auto">
                <h3 class="fw-bold mb-1">Jadwal Kunjungan</h3>
                <p class="text-body-secondary mb-0">Total {{ count($schedules) }} rencana kunjungan</p>
            </div>

            <div class="d-flex w-100 w-md-auto gap-2">
                {{-- Search Box --}}
                <div class="input-group shadow-sm bg-white rounded-3 flex-grow-1" style="min-width: 200px;">
                    <span class="input-group-text bg-transparent border-end-0 text-secondary pe-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0 ps-2"
                        placeholder="Cari nama pasien...">
                </div>

                {{-- Filter Dropdown --}}
                <div class="dropdown">
                    <button class="btn btn-white bg-white border shadow-sm rounded-3 px-3 text-secondary dropdown-toggle h-100" 
                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-funnel me-1"></i> <span id="filterLabel">Semua Status</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                        <li><a class="dropdown-item filter-btn active" href="#" data-status="all">Semua Status</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item filter-btn" href="#" data-status="dijadwalkan">Menunggu</a></li>
                        <li><a class="dropdown-item filter-btn" href="#" data-status="selesai">Selesai</a></li>
                        <li><a class="dropdown-item filter-btn" href="#" data-status="batal">Batal</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Grid Jadwal --}}
        <div class="row g-3" id="scheduleList">
            @forelse($schedules as $schedule)
                {{-- PERUBAHAN: Tambahkan data-status di sini --}}
                <div class="col-12 col-md-6 col-xl-4 search-item" data-status="{{ $schedule->status }}">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                {{-- Tanggal Badge --}}
                                <div class="d-flex flex-column align-items-center bg-light border rounded-3 p-2" style="min-width: 60px;">
                                    <span class="fw-bold fs-5 text-dark">{{ $schedule->tanggal_kunjungan->format('d') }}</span>
                                    <small class="text-muted text-uppercase" style="font-size: 0.65rem;">
                                        {{ $schedule->tanggal_kunjungan->format('M') }}
                                    </small>
                                </div>
                                
                                {{-- Status Badge --}}
                                @if($schedule->status == 'dijadwalkan')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">
                                        <i class="bi bi-clock me-1"></i> Menunggu
                                    </span>
                                @elseif($schedule->status == 'selesai')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                        <i class="bi bi-check-lg me-1"></i> Selesai
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">
                                        <i class="bi bi-x-lg me-1"></i> Batal
                                    </span>
                                @endif
                            </div>

                            {{-- Info Pasien --}}
                            <h5 class="fw-bold text-dark mb-1 name-target">{{ $schedule->patient->nama }}</h5>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-clipboard-pulse me-1"></i> {{ $schedule->jenis_kunjungan }}
                            </p>

                            @if($schedule->catatan)
                                <div class="bg-light-subtle border rounded-3 p-2 mb-3">
                                    <small class="text-secondary fst-italic">
                                        <i class="bi bi-chat-left-text me-1"></i> "{{ $schedule->catatan }}"
                                    </small>
                                </div>
                            @endif

                            <hr class="border-light-subtle my-3">
                            
                            {{-- Action --}}
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    {{ $schedule->tanggal_kunjungan->diffForHumans() }}
                                </small>
                                <a href="{{ route('pasien.show', $schedule->patient_id) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-calendar-x text-secondary opacity-25" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-secondary fw-bold">Belum ada jadwal kunjungan</h5>
                </div>
            @endforelse
        </div>

        {{-- No Result Message --}}
        <div id="noResult" class="text-center py-5 d-none">
            <h5 class="text-secondary fw-bold">Data tidak ditemukan</h5>
            <p class="text-muted">Coba ubah kata kunci atau filter status.</p>
        </div>
    </div>

    {{-- Script Search & Filter Combined --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterBtns = document.querySelectorAll('.filter-btn');
            const items = document.querySelectorAll('.search-item');
            const noResultMsg = document.getElementById('noResult');
            const filterLabel = document.getElementById('filterLabel');

            let currentSearch = '';
            let currentFilter = 'all';

            // Fungsi Utama Filter
            function applyFilters() {
                let hasResult = false;

                items.forEach(function(item) {
                    const name = item.querySelector('.name-target').textContent.toLowerCase();
                    const status = item.getAttribute('data-status');

                    // Logika: Tampilkan jika SEARCH cocok DAN FILTER cocok
                    const matchSearch = name.includes(currentSearch);
                    const matchFilter = (currentFilter === 'all' || status === currentFilter);

                    if (matchSearch && matchFilter) {
                        item.style.display = ''; // Tampilkan
                        hasResult = true;
                    } else {
                        item.style.display = 'none'; // Sembunyikan
                    }
                });

                // Tampilkan pesan jika tidak ada hasil
                if (!hasResult) {
                    noResultMsg.classList.remove('d-none');
                } else {
                    noResultMsg.classList.add('d-none');
                }
            }

            // Event Listener: Search Input
            searchInput.addEventListener('keyup', function() {
                currentSearch = this.value.toLowerCase();
                applyFilters();
            });

            // Event Listener: Filter Buttons
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Update UI tombol aktif
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Update label tombol dropdown
                    filterLabel.textContent = this.textContent;

                    // Update logic filter
                    currentFilter = this.getAttribute('data-status');
                    applyFilters();
                });
            });
        });
    </script>
@endsection