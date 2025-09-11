@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Data Kelas</h1>

                <!-- Card Filter -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h5 class="mb-4">Filter</h5>
                        <form class="row g-2 align-items-end">
                            <!-- Filter Nama -->
                            <div class="col-md-4">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" placeholder="Cari nama...">
                            </div>

                            <!-- Tombol -->
                            <div class="col-md-4 d-flex justify-content-center mt-3 gap-3">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="/tambah-data-kelas" type="button" class="btn btn-primary">Tambah Data</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="card shadow-lg rounded-4">
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
                                    <tr>
                                        <td>1</td>
                                        <td>7A</td>
                                        <td>Memuat 20 siswa dikelas 7A</td>
                                        <td class="text-nowrap">
                                            <a href="/edit-data-kelas" class="btn btn-sm btn-primary">Edit</a>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>7B</td>
                                        <td>Memuat 22 siswa dikelas 7B</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-primary">Edit</button>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>8A</td>
                                        <td>Memuat 18 siswa dikelas 8A</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-primary">Edit</button>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>8B</td>
                                        <td>Memuat 21 siswa dikelas 8B</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-primary">Edit</button>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>9A</td>
                                        <td>Memuat 19 siswa dikelas 9A</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-primary">Edit</button>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
