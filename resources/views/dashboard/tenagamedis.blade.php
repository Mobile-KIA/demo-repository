@extends('layout')

@section('content')
    <style>
        .stat-card {
            transition: transform 0.2s;
            border-radius: 16px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .edu-card img {
            height: 150px;
            object-fit: cover;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }

        .live-indicator {
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }

            100% {
                opacity: 1;
            }
        }

        /* Smooth scroll untuk navigasi sidebar */
        html {
            scroll-behavior: smooth;
        }

        /* Offset untuk scroll-margin agar tidak tertutup header jika ada fixed navbar */
        .section-anchor {
            scroll-margin-top: 100px;
        }
    </style>

    <div class="container-fluid p-0">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Dashboard {{ auth()->user()->role == 'nakes' ? 'Medis' : 'Keluarga' }}</h3>
                <p class="text-body-secondary mb-0">Selamat datang, {{ auth()->user()->name }} 👋</p>
            </div>
            @if (auth()->user()->role == 'nakes')
                <div>
                    <a href="{{ route('pasien.create') }}" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Pasien Baru
                    </a>
                </div>
            @endif
        </div>

        {{-- CARDS STATISTIK (Hanya muncul jika Nakes) --}}
        @if (auth()->user()->role == 'nakes')
            <div class="row g-4 mb-4">
                {{-- Total Pasien --}}
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 stat-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-body-secondary fw-semibold small text-uppercase">Total Pasien</span>
                                <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                            </div>
                            <h2 class="mb-0 fw-bold">{{ $stats['total_pasien'] ?? 0 }}</h2>
                            <span class="small text-body-secondary">Terdaftar dalam sistem</span>
                        </div>
                    </div>
                </div>
                {{-- Data Kehamilan --}}
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 stat-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-body-secondary fw-semibold small text-uppercase">Data Kehamilan</span>
                                <div class="icon-box bg-info bg-opacity-10 text-info">
                                    <i class="bi bi-person-standing-dress"></i>
                                </div>
                            </div>
                            <h2 class="mb-0 fw-bold">{{ $stats['ibu_hamil'] ?? 0 }}</h2>
                            <span class="small text-body-secondary">Rekam medis aktif</span>
                        </div>
                    </div>
                </div>
                {{-- Resiko Tinggi --}}
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 stat-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-danger fw-bold small text-uppercase">Resiko Tinggi</span>
                                <div class="icon-box bg-danger bg-opacity-10 text-danger">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                </div>
                            </div>
                            <h2 class="mb-0 fw-bold text-danger">{{ $stats['resiko_tinggi'] ?? 0 }}</h2>
                            <span class="small text-danger fw-medium">Tensi > 140 mmHg</span>
                        </div>
                    </div>
                </div>
                {{-- Kunjungan --}}
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100 stat-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-body-secondary fw-semibold small text-uppercase">Kunjungan Hari Ini</span>
                                <div class="icon-box bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-calendar-check-fill"></i>
                                </div>
                            </div>
                            <h2 class="mb-0 fw-bold">{{ $stats['kunjungan_hari_ini'] ?? 0 }}</h2>
                            <span class="small text-body-secondary">Pasien diperiksa hari ini</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4">
            {{-- KOLOM UTAMA --}}
            <div class="col-lg-8">

                {{-- 1. FITUR: PEMERIKSAAN TERBARU --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div
                        class="card-header bg-transparent border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold">Pemeriksaan Terbaru</h5>
                            <small class="text-muted"><span class="live-indicator"></span> Update otomatis aktif</small>
                        </div>
                        <a href="{{ route('pasien.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="card-body px-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light-subtle text-uppercase text-secondary small">
                                    <tr>
                                        <th class="px-4 border-0">Nama Pasien</th>
                                        <th class="border-0">Usia Kehamilan</th>
                                        <th class="border-0">Status Tensi</th>
                                        <th class="border-0 text-end px-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentPregnancies as $pregnancy)
                                        @php
                                            $tensi = explode('/', $pregnancy->tekanan_darah);
                                            $isHighRisk = isset($tensi[0]) && (int) $tensi[0] >= 140;
                                        @endphp
                                        <tr>
                                            <td class="px-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                                        style="width: 40px; height: 40px">
                                                        {{ substr($pregnancy->patient->nama ?? 'P', 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">
                                                            {{ $pregnancy->patient->nama ?? 'Nama Tidak Ada' }}</div>
                                                        <div class="small text-body-secondary">Update:
                                                            {{ $pregnancy->updated_at->diffForHumans() }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $pregnancy->usia_kehamilan }} Minggu</td>
                                            <td>
                                                <span
                                                    class="badge {{ $isHighRisk ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-success-subtle text-success border border-success-subtle' }} rounded-pill">
                                                    {{ $isHighRisk ? 'Resiko Tinggi' : 'Normal' }}
                                                    ({{ $pregnancy->tekanan_darah }})
                                                </span>
                                            </td>
                                            <td class="text-end px-4">
                                                <a href="{{ route('pasien.show', $pregnancy->patient_id) }}"
                                                    class="btn btn-sm btn-light border">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                <i class="bi bi-clipboard-x fs-1 d-block mb-2 opacity-25"></i>
                                                Belum ada data pemeriksaan terbaru.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- 2. FITUR: EDUKASI (Layanan) --}}
                <div id="section-edukasi" class="section-anchor">
                    <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                        <h5 class="fw-bold mb-0">Layanan Edukasi Kesehatan</h5>
                        <a href="#" class="btn btn-sm btn-link text-decoration-none p-0">Lihat Semua Artikel</a>
                    </div>

                    <div class="row g-4">
                        @forelse ($articles ?? [] as $article)
                            <div class="col-md-6 col-xl-4">
                                <div class="card border-0 shadow-sm h-100 stat-card edu-card overflow-hidden">
                                    <div class="position-relative">
                                        <img src="{{ $article['image'] }}" class="card-img-top"
                                            alt="{{ $article['title'] }}" style="height: 160px; object-fit: cover;">
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge bg-primary bg-opacity-75 rounded-pill shadow-sm">
                                                {{ $article['category'] }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="fw-bold mb-2 text-dark">{{ $article['title'] }}</h6>
                                        <p class="small text-muted mb-3 flex-grow-1"
                                            style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $article['desc'] }}
                                        </p>
                                        <hr class="my-3 opacity-25">
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <span class="small text-muted"><i class="bi bi-clock me-1"></i> 5 mnt
                                                baca</span>
                                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                Baca <i class="bi bi-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-journal-x fs-1 opacity-25"></i>
                                    <p class="mt-2">Belum ada konten edukasi tersedia.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- SIDEBAR KANAN --}}
                <div class="col-lg-4">
                    {{-- 3. FITUR: JADWAL KONTROL (Sidebar) --}}
                    <div id="section-jadwal" class="card border-0 shadow-sm mb-4 section-anchor">
                        <div
                            class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Jadwal Kontrol</h5>
                            @if (auth()->user()->role == 'nakes')
                                {{-- Tombol Tambah Jadwal --}}
                                <button class="btn btn-sm btn-primary rounded-circle" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahJadwal">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            @else
                                <i class="bi bi-calendar3 text-primary"></i>
                            @endif
                        </div>
                        <div class="card-body px-4 pb-4">
                            @forelse($upcomingSchedules ?? [] as $schedule)
                                <div class="d-flex align-items-center mb-3 p-3 border rounded-3 bg-light-subtle">
                                    <div class="bg-primary text-white p-2 rounded text-center me-3"
                                        style="min-width: 55px;">
                                        <div class="fw-bold fs-5">{{ date('d', strtotime($schedule->date)) }}</div>
                                        <div style="font-size: 10px;">
                                            {{ strtoupper(date('M', strtotime($schedule->date))) }}</div>
                                    </div>
                                    <div>
                                        <div class="fw-bold small text-truncate" style="max-width: 150px;">
                                            {{ $schedule->title }}</div>
                                        <div class="small text-muted"><i
                                                class="bi bi-clock me-1"></i>{{ $schedule->time }} WIB</div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted border border-dashed rounded-3">
                                    <i class="bi bi-calendar-x mb-2 d-block fs-3 opacity-25"></i>
                                    <small>Belum ada jadwal terdekat.</small>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Banner Panduan KIA + Download --}}
                    <div class="card border-0 shadow-sm bg-primary text-white mb-4">
                        <div class="card-body p-4 position-relative overflow-hidden">
                            <i class="bi bi-info-circle position-absolute top-0 end-0 mt-n2 me-n2 text-white opacity-25"
                                style="font-size: 8rem;"></i>
                            <h5 class="fw-bold position-relative z-1">Panduan KIA</h5>
                            <p class="small opacity-75 position-relative z-1">Panduan praktis kesehatan ibu dan anak edisi
                                digital.</p>
                            <div class="d-grid gap-2 position-relative z-1">
                                <button class="btn btn-sm btn-light text-primary fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#modalPanduan">
                                    <i class="bi bi-book-half me-1"></i> Buka Panduan
                                </button>
                                <a href="{{ asset('assets/pdf/buku-kia-lengkap.pdf') }}"
                                    class="btn btn-sm btn-outline-light fw-bold" download>
                                    <i class="bi bi-download me-1"></i> Download PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Log Aktivitas --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-transparent border-0 pt-4 px-4">
                            <h5 class="mb-0 fw-bold">Aktivitas Terbaru</h5>
                        </div>
                        <div class="card-body px-4 pb-4">
                            @forelse ($todaysActivity ?? [] as $activity)
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3">
                                        <span
                                            class="badge bg-secondary-subtle text-secondary small">{{ $activity->updated_at->format('H:i') }}</span>
                                    </div>
                                    <div class="border-start ps-3 pb-2">
                                        <div class="fw-bold small">Pemeriksaan Selesai</div>
                                        <div class="small text-body-secondary">Pasien: Ny.
                                            {{ $activity->patient->nama ?? 'Umum' }}</div>
                                    </div>
                                </div>
                            @empty
                                <small class="text-muted">Tidak ada aktivitas hari ini.</small>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL PANDUAN KIA --}}
        <div class="modal fade" id="modalPanduan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white px-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-journal-medical me-2"></i>E-Buku KIA Digital</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="text-center mb-4">
                            <i class="bi bi-file-earmark-pdf text-danger display-1"></i>
                            <h4 class="fw-bold mt-2">Buku KIA Edisi 2024</h4>
                            <p class="text-muted">Kesehatan Ibu dan Anak (Kemenkes RI)</p>
                        </div>

                        <div class="accordion accordion-flush" id="accordionKIA">
                            {{-- Section 1 --}}
                            <div class="accordion-item border-bottom">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fw-bold text-primary" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#kia1">
                                        <i class="bi bi-check2-circle me-2"></i> 1. Pemeriksaan Ibu Hamil (ANC)
                                    </button>
                                </h2>
                                <div id="kia1" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionKIA">
                                    <div class="accordion-body small text-muted">
                                        <ul>
                                            <li>Timbang Berat Badan dan Tinggi Badan setiap kunjungan.</li>
                                            <li>Pemeriksaan Tekanan Darah (Normal: < 140/90).</li>
                                            <li>Pemberian Tablet Tambah Darah (Minimal 90 tablet selama hamil).</li>
                                            <li>Pemeriksaan USG oleh Dokter minimal 2 kali selama kehamilan.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- Section 2 --}}
                            <div class="accordion-item border-bottom">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold text-danger" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#kia2">
                                        <i class="bi bi-exclamation-triangle me-2"></i> 2. Tanda Bahaya Kehamilan
                                    </button>
                                </h2>
                                <div id="kia2" class="accordion-collapse collapse" data-bs-parent="#accordionKIA">
                                    <div class="accordion-body small text-danger">
                                        <strong>Segera ke rumah sakit jika mengalami:</strong>
                                        <ul class="mt-2">
                                            <li>Perdarahan lewat jalan lahir.</li>
                                            <li>Bengkak pada kaki, tangan, dan wajah disertai sakit kepala hebat.</li>
                                            <li>Demam tinggi atau ketuban pecah sebelum waktunya.</li>
                                            <li>Gerakan janin berkurang dibanding biasanya.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4">
                        <button type="button" class="btn btn-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">Tutup</button>
                        <a href="{{ asset('assets/pdf/buku-kia-lengkap.pdf') }}"
                            class="btn btn-primary rounded-pill px-4" download>
                            <i class="bi bi-download me-1"></i> Download PDF Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
