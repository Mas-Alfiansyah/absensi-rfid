@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Data Siswa</h1>

                <!-- Card Filter -->
                <div class="card garis shadow-md rounded-4 mb-5">
                    <div class="card-body">
                        <h5 class="mb-4">Filter</h5>
                        <form action="{{ route('siswas.index') }}" method="GET" class="row g-2 align-items-end">
                            <!-- Filter Nama -->
                            <div class="col-md-4">
                                <label class="form-label">Nama</label>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="Cari nama...">
                            </div>

                            <!-- Tombol -->
                            <div class="col-md-4 d-flex justify-content-center mt-3 gap-3">
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('siswas.index') }}" class="btn btn-danger">Reset</a>
                                <a href="{{ route('siswas.create') }}" type="button" class="btn btn-primary">Tambah
                                    Data</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="card garis shadow-md rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Siswa</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>NISN</th>
                                        <th>Alamat</th>
                                        <th>Tetala</th>
                                        <th>L/P</th>
                                        <th>WA Ortu</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse($siswas as $siswa)
                                        <tr>
                                            <td>{{ $siswas->firstItem() + $loop->index }}</td>
                                            <td>{{ $siswa->nama_lengkap }}</td>
                                            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td>{{ $siswa->alamat }}</td>
                                            <td>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</td>
                                            <td>{{ $siswa->jenis_kelamin }}</td>
                                            <td>{{ $siswa->no_wa }}</td>
                                            <td class="text-nowrap">
                                                <a href="{{ route('siswas.show', $siswa->id) }}"
                                                    class="btn btn-sm btn-warning">Lihat</a>
                                                <a href="{{ route('siswas.edit', $siswa->id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('siswas.destroy', $siswa->id) }}" method="POST"
                                                    style="display:inline-block;" id="form-hapus-{{ $siswa->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="hapusPengguna({{ $siswa->id }})">Hapus</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Data tidak ditemukan</td>
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
