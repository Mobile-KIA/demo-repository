@extends('layout')

@section('content')
<div class="container-fluid px-4 py-5"> {{-- Pakai container-fluid agar lebar mentok --}}
    
    {{-- HEADER SECTION --}}
    <div class="d-flex align-items-center mb-5 border-bottom pb-4">
        <a href="{{ route('dashboard.orangtua') }}" class="btn btn-white border shadow-sm rounded-circle p-0 d-flex align-items-center justify-content-center me-4 transition-hover" style="width: 50px; height: 50px;">
            <i class="bi bi-arrow-left fs-5 text-secondary"></i>
        </a>
        <div>
            <h2 class="fw-bold mb-0 text-dark display-6">{{ $child->nama }}</h2>
            <div class="d-flex align-items-center gap-3 mt-1 text-muted">
                <span><i class="bi bi-clock me-1"></i> Usia: {{ $child->usia }}</span>
                <span>•</span>
                <span><i class="bi bi-gender-ambiguous me-1"></i> {{ $child->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
            </div>
        </div>
    </div>

    {{-- BAGIAN 1: GRAFIK (FULL WIDTH) --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-bar-chart-line text-primary me-2"></i>Grafik Perkembangan
            </h5>
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Visualisasi</span>
        </div>
        
        <div class="position-relative" style="height: 400px; width: 100%;">
            @if($chartLabels->count() > 0)
                <canvas id="growthChart"></canvas>
            @else
                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted opacity-50">
                    <i class="bi bi-graph-up-arrow fs-1 mb-2"></i>
                    <small>Data belum cukup untuk menampilkan grafik.</small>
                </div>
            @endif
        </div>
    </div>


    {{-- BAGIAN 2: GRID 2 KOLOM (RIWAYAT UKUR & VAKSIN) --}}
    <div class="row g-4">
        
        {{-- KOLOM KIRI: RIWAYAT PENGUKURAN --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0">Riwayat Pengukuran</h5>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">TB & BB</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    {{-- List Scrollable jika data banyak --}}
                    <div class="overflow-auto custom-scrollbar" style="max-height: 500px;">
                        @forelse($historyGrowths as $growth)
                            <div class="p-3 border-bottom border-light-subtle d-flex align-items-center justify-content-between hover-bg">
                                <div>
                                    <span class="fw-bold text-dark d-block">{{ $growth->tanggal->format('d M Y') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($child->tgl_lahir)->diffInMonths($growth->tanggal) }} Bulan</small>
                                </div>
                                <div class="d-flex gap-3 text-end">
                                    <div>
                                        <span class="d-block fw-bold fs-5 text-dark">{{ $growth->berat_badan }}</span>
                                        <small class="text-muted" style="font-size: 10px;">KG</small>
                                    </div>
                                    <div class="vr opacity-25"></div>
                                    <div>
                                        <span class="d-block fw-bold fs-5 text-dark">{{ $growth->tinggi_badan }}</span>
                                        <small class="text-muted" style="font-size: 10px;">CM</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted opacity-50">Belum ada data pengukuran.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: RIWAYAT IMUNISASI --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom pt-4 px-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0">Riwayat Vaksinasi</h5>
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">Imunisasi</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="overflow-auto custom-scrollbar" style="max-height: 500px;">
                        @forelse($child->immunizations as $immune)
                            <div class="p-3 border-bottom border-light-subtle hover-bg">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <span class="fw-bold text-dark fs-5">{{ $immune->jenis_vaksin }}</span>
                                    <span class="bg-light text-secondary border px-2 py-1 rounded small fw-bold">
                                        {{ $immune->tanggal_imunisasi->format('d M Y') }}
                                    </span>
                                </div>
                                @if($immune->catatan)
                                    <div class="d-flex align-items-start gap-2 bg-info bg-opacity-10 p-2 rounded text-dark small">
                                        <i class="bi bi-info-circle-fill text-info mt-1"></i>
                                        <span>{{ $immune->catatan }}</span>
                                    </div>
                                @endif
                                @if($immune->nomor_batch)
                                    <div class="mt-2 text-muted small font-monospace">Batch: {{ $immune->nomor_batch }}</div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted opacity-50">Belum ada data imunisasi.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- SCRIPT CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('growthChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            label: 'Berat (kg)',
                            data: @json($chartBerat),
                            borderColor: '#198754',
                            backgroundColor: 'rgba(25, 135, 84, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            yAxisID: 'y',
                            fill: true
                        },
                        {
                            label: 'Tinggi (cm)',
                            data: @json($chartTinggi),
                            borderColor: '#0dcaf0',
                            borderWidth: 3,
                            borderDash: [5, 5], // Garis putus-putus untuk tinggi biar beda
                            tension: 0.4,
                            yAxisID: 'y1',
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // PENTING AGAR NGIKUTIN TINGGI DIV
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { 
                            type: 'linear', display: true, position: 'left', 
                            title: {display: true, text: 'Berat (kg)'} 
                        },
                        y1: { 
                            type: 'linear', display: true, position: 'right', 
                            grid: { drawOnChartArea: false },
                            title: {display: true, text: 'Tinggi (cm)'} 
                        }
                    }
                }
            });
        }
    });
</script>

<style>
    /* Custom Scrollbar yang halus */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

    /* Hover effect pada list item */
    .hover-bg { transition: background-color 0.2s; }
    .hover-bg:hover { background-color: #f8f9fa; }

    .transition-hover:hover { transform: translateX(-3px); }
</style>
@endsection