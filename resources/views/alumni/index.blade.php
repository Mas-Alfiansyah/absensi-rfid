@extends('layouts.app')
@section('content')
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Daftar Alumni</h1>

                <!-- Card Filter -->
                <div class="card garis shadow-md rounded-4 mb-5">
                    <div class="card-body">
                        <h5 class="mb-4">Filter Alumni</h5>
                        <form action="{{ route('alumni.index') }}" method="GET" class="row g-2 align-items-end">
                            <!-- Filter Nama -->
                            <div class="col-md-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="Cari nama...">
                            </div>

                            <!-- Filter Tahun Lulus -->
                            <div class="col-md-3">
                                <label class="form-label">Tahun Lulus</label>
                                <select name="tahun_lulus" class="form-select">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($tahunLulusOptions as $tahun)
                                        <option value="{{ $tahun }}"
                                            {{ request('tahun_lulus') == $tahun ? 'selected' : '' }}>
                                            {{ $tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Filter Kelas Terakhir -->
                            <div class="col-md-3">
                                <label class="form-label">Kelas Terakhir</label>
                                <input type="text" name="kelas_terakhir" value="{{ request('kelas_terakhir') }}"
                                    class="form-control" placeholder="Cari kelas...">
                            </div>

                            <!-- Tombol -->
                            <div class="col-md-3 d-flex flex-column flex-md-row justify-content-center mt-3 gap-3 ">
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('alumni.index') }}" class="btn btn-danger">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Alumni -->
                <div class="card garis shadow-md rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Alumni</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>Kelas Terakhir</th>
                                        <th>Tahun Lulus</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse($siswas as $siswa)
                                        <tr>
                                            <td>{{ $siswas->firstItem() + $loop->index }}</td>
                                            <td>{{ $siswa->nama_lengkap }}</td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td>{{ $siswa->kelas_terakhir ?? '-' }}</td>
                                            <td>{{ $siswa->tahun_lulus ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('alumni.show', $siswa->id) }}"
                                                    class="btn btn-sm btn-warning">Lihat</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Data alumni tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @include('partials.pagination-bottom', ['data' => $siswas])
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
