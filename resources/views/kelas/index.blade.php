@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Data Kelas</h1>

                <!-- Card Filter -->
                <div class="card garis rounded-4 mb-5">
                    <div class="card-body">
                        <h5 class="mb-4">Filter</h5>
                        <form action="{{ route('kelas.index') }}" method="GET" class="row g-2 align-items-end">
                            <!-- Filter Nama -->
                            <div class="col-md-4">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ request('nama') }}" placeholder="Cari nama...">
                            </div>

                            <!-- Tombol -->
                            <div class="col-md-4 d-flex justify-content-center mt-3 gap-3">
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('kelas.index') }}" class="btn btn-danger">Reset</a>
                                <a href="{{ route('kelas.create') }}" type="button" class="btn btn-primary">Tambah Data</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="card garis shadow-lg rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Kelas</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th style="width: 50px">No</th>
                                        <th>Kelas</th>
                                        <th>Deskripsi</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($kelas as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nama_kelas }}</td>
                                            <td>Memuat {{ $k->siswas_count }} Siswa di kelas ini</td>
                                            <td class="text-nowrap">
                                                {{-- <a href="{{ route('kelas.show', $k->id) }}" class="btn btn-info btn-sm">Lihat</a> --}}
                                                <a href="{{ route('kelas.edit', $k->id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('kelas.destroy', $k->id) }}" method="POST"
                                                    style="display:inline;" id="form-hapus-{{ $k->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="hapusPengguna({{ $k->id }})"
                                                        class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @include('partials.pagination-bottom', ['data' => $kelas])
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
