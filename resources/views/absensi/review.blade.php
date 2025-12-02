@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">Review & Ekspor Absensi</h1>

        <!-- Filter Form -->
        <div class="card garis shadow-md rounded-4 mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label>Kelas</label>
                        <select name="kelas_id" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ $start_date }}">
                    </div>

                    <div class="col-md-2">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $end_date }}">
                    </div>

                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-success">Filter</button>
                            <a href="{{ route('absensi.review') }}" class="btn btn-danger">Reset</a>
                            <a href="{{ route('absensi.index') }}" class="btn btn-outline-danger">Kembali</a>
                        </div>
                    </div>
                    @if ($siswas->count() > 0)
                        <div class="col-md-6  mt-3 gap-3">
                            <a href="{{ route('absensi.export.excel', request()->query()) }}"class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Ekspor Excel
                            </a>
                            <a href="{{ route('absensi.export.pdf', request()->query()) }}" class="btn btn-danger">
                                <i class="fas fa-file-pdf"></i> Ekspor PDF
                            </a>
                        </div>
                    @endif
                    <h5 class="text-warning">Warning</h5>
                    <ul class="mt-1">
                        <li>1. Sebelum Export mohon pilih kelasnya terlebih dahulu</li>
                        <li>2. Direkomendasikan pilih waktu nya itu dalam format 7 hari</li>
                        <li>3. Setelah itu anda bisa export ke Excel & PDF</li>
                    </ul>
                </form>
            </div>
        </div>

        <!-- Preview Table -->
        @if ($siswas->count() > 0)
            <div class="card garis shadow-md rounded-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle table-hover">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th rowspan="2" style="text-align: center; width: 50px">No</th>
                                    <th rowspan="2">Nama</th>
                                    <th rowspan="2">Kelas</th>
                                    @foreach ($tanggal_range as $tanggal)
                                        <th colspan="2" class="text-center">
                                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l') }}
                                        </th>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach ($tanggal_range as $tanggal)
                                        <th class="text-center">M</th>
                                        <th class="text-center">P</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswas as $siswa)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $siswa->nama_lengkap }}</td>
                                        <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>

                                        @foreach ($tanggal_range as $tanggal)
                                            @php
                                                $scan = $siswa->scans->where('tanggal', $tanggal)->first();
                                            @endphp

                                            <!-- Kolom Masuk -->
                                            <td class="text-center">
                                                @if ($scan)
                                                    @if ($scan->status === 'sakit')
                                                        <span class="badge bg-info">S</span>
                                                    @elseif($scan->status === 'izin')
                                                        <span class="badge bg-primary">I</span>
                                                    @elseif($scan->status === 'alpha')
                                                        <span class="badge bg-danger">A</span>
                                                    @elseif($scan->jam_masuk)
                                                        <span class="badge bg-success">✓</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>

                                            <!-- Kolom Pulang -->
                                            <td class="text-center">
                                                @if ($scan && $scan->jam_keluar)
                                                    <span class="badge bg-success">✓</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning">Tidak ada data absensi untuk ditampilkan.</div>
        @endif
    </div>
@endsection
