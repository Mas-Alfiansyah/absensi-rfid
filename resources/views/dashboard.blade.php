@extends('layouts.app')

@section('content')
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <h1 class="mb-4 text-left fw-bold">Dashboard</h1>

            <div class="row g-4 mb-4">

                <!-- TOTAL SISWA -->
                <div class="col-md-3">
                    <div class="card garis shadow-sm rounded-4 position-relative px-3 py-4 h-auto">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle bg-primary bg-opacity-10 p-3 d-flex align-items-center justify-content-center">
                                <iconify-icon icon="tabler:users" width="32" class="text-primary"></iconify-icon>
                            </div>
                            <div>
                                <h3 class="fw-bold text-dark mb-0">{{ $totalSiswa }}</h3>
                                <small class="text-muted">Total Siswa</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HADIR -->
                <div class="col-md-3">
                    <div class="card garis shadow-sm rounded-4 position-relative px-3 py-4 h-auto">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle bg-success bg-opacity-10 p-3 d-flex align-items-center justify-content-center">
                                <iconify-icon icon="tabler:circle-check" width="32" class="text-success"></iconify-icon>
                            </div>
                            <div>
                                <h3 class="fw-bold text-dark mb-0">{{ $hadirToday }}</h3>
                                <small class="text-muted">Hadir Hari Ini</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TERLAMBAT -->
                <div class="col-md-3">
                    <div class="card garis shadow-sm rounded-4 position-relative px-3 py-4 h-auto">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle bg-warning bg-opacity-10 p-3 d-flex align-items-center justify-content-center">
                                <iconify-icon icon="tabler:clock-exclamation" width="32"
                                    class="text-warning"></iconify-icon>
                            </div>
                            <div>
                                <h3 class="fw-bold text-dark mb-0">{{ $terlambatToday }}</h3>
                                <small class="text-muted">Terlambat</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BELUM ABSEN -->
                <div class="col-md-3">
                    <div class="card garis shadow-sm rounded-4 position-relative px-3 py-4 h-auto">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="rounded-circle bg-secondary bg-opacity-10 p-3 d-flex align-items-center justify-content-center">
                                <iconify-icon icon="tabler:user-off" width="32" class="text-secondary"></iconify-icon>
                            </div>
                            <div>
                                <h3 class="fw-bold text-dark mb-0">{{ $belumAbsen }}</h3>
                                <small class="text-muted">Belum Absen</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row mb-4">
                <!-- Grafik Tren Absensi 7 Hari Terakhir -->
                <div class="col-md-8">
                    <div class="card garis rounded-4 h-100">
                        <div class="card-body p-3">
                            <h5 class="card-title mb-1">Tren Absensi</h5>
                            <p class="card-subtitle text-muted small mb-3">7 Hari Terakhir (Hadir & Terlambat)</p>
                            <div class="chart-container" style="position: relative; height:300px;">
                                <canvas id="trendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Donut (Sakit, Izin, Alpha) -->
                <div class="col-md-4">
                    <div class="card garis rounded-4 h-100">
                        <div class="card-body p-3 d-flex flex-column">
                            <h5 class="card-title mb-1">Status Kehadiran</h5>
                            <p class="card-subtitle text-muted small mb-3">Sakit, Izin, Alpha (Hari Ini)</p>

                            <div class="chart-container flex-grow-1"
                                style="position: relative; height:200px; min-height:200px;">
                                <canvas id="statusDonutChart"></canvas>
                            </div>

                            <!-- Custom Legend/Stats below donut if needed for clarity -->
                            <div class="mt-3 d-flex justify-content-around text-center">
                                <div>
                                    <h5 class="fw-bold text-info mb-0">{{ $sakitToday }}</h5>
                                    <small class="text-muted" style="font-size: 0.75rem;">Sakit</small>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-primary mb-0">{{ $izinToday }}</h5>
                                    <small class="text-muted" style="font-size: 0.75rem;">Izin</small>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-danger mb-0">{{ $alphaToday }}</h5>
                                    <small class="text-muted" style="font-size: 0.75rem;">Alpha</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel 10 Siswa Terakhir Absen -->
            <div class="card garis rounded-4">
                <div class="card-body">
                    <h4 class="mb-3">10 Siswa Terakhir Absen</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle table-hover">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Waktu Absen</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $index => $scan)
                                    <tr class="text-center">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $scan->siswa->nama_lengkap }}</td>
                                        <td>{{ $scan->siswa->kelas->nama_kelas ?? '-' }}</td>
                                        <td>{{ $scan->jam_masuk }}</td>
                                        <td>
                                            @if ($scan->status === 'hadir')
                                                <span class="badge bg-success">Hadir</span>
                                            @elseif($scan->status === 'lambat' || $scan->status === 'terlambat')
                                                <span class="badge bg-warning text-dark">Terlambat</span>
                                            @elseif($scan->status === 'sakit')
                                                <span class="badge bg-info">Sakit</span>
                                            @elseif($scan->status === 'izin')
                                                <span class="badge bg-secondary">Izin</span>
                                            @else
                                                <span class="badge bg-danger">Alpha</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Belum ada aktivitas absensi hari ini
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js & Iconify -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trend Chart
            const ctx = document.getElementById('trendChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Hadir/Terlambat',
                        data: @json($chartData),
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false, // Clean look
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    }
                }
            });

            // Status Donut Chart (Sakit, Izin, Alpha)
            const donutCtx = document.getElementById('statusDonutChart').getContext('2d');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Sakit', 'Izin', 'Alpha'],
                    datasets: [{
                        data: [{{ $sakitToday }}, {{ $izinToday }}, {{ $alphaToday }}],
                        backgroundColor: [
                            '#36A2EB', // Sakit (Blue)
                            '#FFCE56', // Izin (Yellow)
                            '#FF6384' // Alpha (Red)
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // We have custom legend
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    },
                    cutout: '75%', // Thinner donut
                }
            });
        });
    </script>
@endsection
