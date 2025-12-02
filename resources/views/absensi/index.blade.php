@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Absensi</h1>

                <!-- Card Filter -->
                <div class="card garis shadow-md mb-5 rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Filter Absensi</h5>
                        <form method="GET" class="row g-2 align-items-end">
                            <!-- Filter Kelas -->
                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas_id" class="form-select">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Filter Periode -->
                            <div class="col-md-2">
                                <label class="form-label">Periode</label>
                                <select name="periode" class="form-select">
                                    <option value="hari_ini" {{ request('periode') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="minggu_ini" {{ request('periode') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="bulan_ini" {{ request('periode') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                                    <option value="tahun_ini" {{ request('periode') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                                </select>
                            </div>
                            
                            <!-- Filter Nama -->
                            <div class="col-md-2">
                                <label class="form-label">Nama</label>
                                <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}">
                            </div>

                            <!-- Tombol -->
                            <div class="col-md-5">
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('absensi.index') }}" class="btn btn-danger">Reset</a>
                                <a href="{{ route('absensi.review') }}" class="btn btn-primary">Pre-Ekspor</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="card garis shadow-md rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Absensi</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($absensi as $key => $absen)
                                    <tr class="text-center">
                                        <td>{{ $absensi->firstItem() + $key }}</td>
                                        <td>{{ $absen->siswa->nama_lengkap }}</td>
                                        <td>{{ $absen->siswa->kelas->nama_kelas ?? '-' }}</td>
                                        <td>{{ $absen->tanggal }}</td>
                                        <td>{{ $absen->jam_masuk ?? '-' }}</td>
                                        <td>{{ $absen->jam_keluar ?? '-' }}</td>
                                        <td>
                                            @if($absen->status == 'hadir')
                                                <span class="badge bg-success">Hadir</span>
                                            @elseif($absen->status == 'lambat')
                                                <span class="badge bg-warning text-dark">Lambat</span>
                                            @elseif($absen->status == 'sakit')
                                                <span class="badge bg-info">Sakit</span>
                                            @elseif($absen->status == 'izin')
                                                <span class="badge bg-primary">Izin</span>
                                            @elseif($absen->status == 'alpha')
                                                <span class="badge bg-danger">Alpha</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $absensi->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection