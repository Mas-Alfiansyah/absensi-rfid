@extends('layouts.app')

@section('content')
<div class="body-wrapper-inner">
    <div class="container-fluid">
        <h1 class="mb-4 text-left fw-bold">Dashboard</h1>

        <!-- Card Statistik -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card rounded-4 bg-biru-card text-center p-3 shadow-sm h-100">
                    <h5 class="text-black mb-2">Total Siswa</h5>
                    <h2 class="fw-bold text-primary mb-0">{{ $totalSiswa }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card rounded-4 bg-ijo-card text-center p-3 shadow-sm h-100">
                    <h5 class="text-black mb-2">Total Absen</h5>
                    <h2 class="fw-bold text-success mb-0">{{ $totalAbsen }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card rounded-4 bg-merah-card text-center p-3 shadow-sm h-100">
                    <h5 class="text-black mb-2">Belum Absen</h5>
                    <h2 class="fw-bold text-danger mb-0">{{ $belumAbsen }}</h2>
                </div>
            </div>
        </div>

        <!-- Grafik Lingkaran Modern - DIKECILKAN -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card garis rounded-4 h-100">
                    <div class="card-body d-flex flex-column p-3"> <!-- Padding dikurangi -->
                        <h5 class="card-title mb-1">Absensi Hari Ini</h5> <!-- h4 menjadi h5 -->
                        <p class="card-subtitle text-muted small mb-2">Perbandingan Siswa Sudah & Belum Absen</p> <!-- Font kecil -->
                        <div class="chart-container mt-2 flex-grow-1"> <!-- Margin top dikurangi -->
                            <canvas id="donutChart" height="180"></canvas> <!-- Height dikurangi -->
                        </div>
                        <div class="card-footer bg-transparent border-top mt-2 pt-2 px-0"> <!-- Padding dikurangi -->
                            <div class="d-flex justify-content-center flex-wrap gap-2"> <!-- Gap dikurangi -->
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-1 p-1"></span> <!-- Padding badge dikurangi -->
                                    <small class="text-muted">Sudah Absen</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger me-1 p-1"></span> <!-- Padding badge dikurangi -->
                                    <small class="text-muted">Belum Absen</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Batang Modern - DIKECILKAN -->
            <div class="col-md-6">
                <div class="card garis rounded-4 h-100">
                    <div class="card-body d-flex flex-column p-3"> <!-- Padding dikurangi -->
                        <div class="d-flex justify-content-between align-items-center mb-2"> <!-- Margin bottom dikurangi -->
                            <div>
                                <h5 class="card-title mb-1">Status Absensi</h5> <!-- h4 menjadi h5 -->
                                <p class="card-subtitle text-muted small mb-0">Sakit, Izin, Alpha</p> <!-- Font kecil -->
                            </div>
                            <div class="d-flex flex-wrap gap-1"> <!-- Gap dikurangi -->
                                <div class="d-flex align-items-center">
                                    <span class="ling-sakit"></span> <!-- Menggunakan badge -->
                                    <small class="text-muted">Sakit</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="ling-izin"></span> <!-- Menggunakan badge -->
                                    <small class="text-muted">Izin</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="ling-alpha"></span> <!-- Menggunakan badge -->
                                    <small class="text-muted">Alpha</small>
                                </div>
                            </div>
                        </div>
                        <div class="chart-container flex-grow-1 mt-1"> <!-- Margin top dikurangi -->
                            <canvas id="barChart" height="180"></canvas> <!-- Height dikurangi -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data Absensi -->
        <div class="card garis rounded-4">
            <div class="card-body">
                <h4 class="mb-3">Data Absensi Hari Ini</h4>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle table-hover">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($scansToday as $index => $scan)
                                <tr class="text-center">
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ $scan->siswa->nama_lengkap }}</td>
                                    <td>{{ $scan->siswa->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $scan->jam_masuk ?? '-' }}</td>
                                    <td>{{ $scan->jam_keluar ?? '-' }}</td>
                                    <td>
                                        @if($scan->status === 'hadir')
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif($scan->status === 'lambat')
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
                                    <td colspan="6" class="text-center py-4">Belum ada data absensi hari ini</td>
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
    // Donut Chart - Disesuaikan untuk ukuran lebih kecil
    document.addEventListener('DOMContentLoaded', function() {
        const donutCtx = document.getElementById('donutChart').getContext('2d');
        const donutChart = new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Sudah Absen', 'Belum Absen'],
                datasets: [{
                    data: [{{ $totalAbsen }}, {{ $belumAbsen }}],
                    backgroundColor: ['#198754', '#dc3545'],
                    borderWidth: 0,
                    hoverOffset: 8 // Dikurangi dari 10
                }]
            },
            options: {
                cutout: '70%', // Dikurangi dari 75% untuk ukuran lebih kecil
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        bodyFont: {
                            size: 12 // Font tooltip lebih kecil
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Bar Chart - Disesuaikan untuk ukuran lebih kecil
        const barCtx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: ['Sakit', 'Izin', 'Alpha'],
                datasets: [{
                    label: 'Jumlah Siswa',
                    data: [
                        {{ $scansToday->where('status', 'sakit')->count() }},
                        {{ $scansToday->where('status', 'izin')->count() }},
                        {{ $scansToday->where('status', 'alpha')->count() }}
                    ],
                    backgroundColor: ['#0dcaf0', '#6c757d', '#dc3545'],
                    borderRadius: 3, // Dikurangi dari 5
                    borderSkipped: false,
                    barPercentage: 0.4, // Bar lebih tipis
                    categoryPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        bodyFont: {
                            size: 12 // Font tooltip lebih kecil
                        },
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        ticks: { 
                            stepSize: 1,
                            font: {
                                size: 10 // Font sumbu Y lebih kecil
                            }
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' } // Grid lebih transparan
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: {
                                size: 10 // Font sumbu X lebih kecil
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection