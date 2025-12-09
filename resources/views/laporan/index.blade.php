@extends('layouts.app')

@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Laporan Kehadiran Siswa</h1>

                <!-- Card Filter -->
                <div class="card garis shadow-md rounded-4 mb-5">
                    <div class="card-body">
                        <h5 class="mb-4">Filter</h5>
                        <form action="{{ route('laporan.index') }}" method="GET" class="row g-2 align-items-end">
                            <!-- Filter Kelas -->
                            <div class="col-md-2">
                                <label class="form-label">Kelas</label>
                                <select name="kelas_id" class="form-select">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}"
                                            {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Filter Bulan -->
                            <div class="col-md-2">
                                <label class="form-label">Bulan</label>
                                <select name="bulan" class="form-select">
                                    <option value="">Semua Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <!-- Filter Tahun -->
                            <div class="col-md-2">
                                <label class="form-label">Tahun</label>
                                <select name="tahun" class="form-select">
                                    <option value="">Semua Tahun</option>
                                    @for ($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <!-- Filter Nama -->
                            <div class="col-md-3">
                                <input type="text" name="nama" class="form-control" placeholder="Cari nama..."
                                    value="{{ request('nama') }}">
                            </div>

                            <!-- Tombol -->
                            <div class="col-md-3 d-flex flex-column flex-md-row justify-content-center mt-3 gap-2">
                                <a href="{{ route('laporan.index') }}" class="btn btn-danger">Reset</a>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Laporan -->
                <div class="card garis shadow-md rounded-4 rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Laporan</h5>
                        <div class="table-responsive" id="laporan-data">
                            @if (isset($rekap) && count($rekap) > 0)
                                <table class="table table-bordered align-middle table-hover">
                                    <thead class="table-primary text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Total Hadir</th>
                                            <th>Total Sakit</th>
                                            <th>Total Izin</th>
                                            <th>Total Alpha</th>
                                            <th>Total Lambat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rekap as $i => $r)
                                            <tr class="text-center">
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $r['siswa']->nama_lengkap ?? '-' }}</td>
                                                <td>{{ $r['siswa']->kelas->nama_kelas ?? '-' }}</td>
                                                <td>
                                                    <span class="badge bg-success">{{ $r['total_hadir'] }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $r['total_sakit'] }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $r['total_izin'] }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-danger">{{ $r['total_alpha'] }}</span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge bg-warning text-dark">{{ $r['total_lambat'] }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="alert alert-warning text-center">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10" />
                                        <line x1="12" y1="8" x2="12" y2="12" />
                                        <line x1="12" y1="16" x2="12.01" y2="16" />
                                    </svg>
                                    <p class="mt-2 mb-0">Data tidak ditemukan.</p>
                                </div>
                            @endif
                        </div>

                        @include('partials.pagination-bottom', ['data' => $siswas])
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
