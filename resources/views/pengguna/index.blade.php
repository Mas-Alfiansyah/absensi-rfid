@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Data Pengguna</h1>

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
                            <div class="col-md-6 d-flex justify-content-center mt-3 gap-3">
                                <button type="submit" class="btn btn-success">Filter</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <a href="/tambah-pengguna" type="button" class="btn btn-primary">Tambah Pengguna</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Pengguna</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th style="width: 50px">No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Role</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr>
                                        <td>1</td>
                                        <td>Fadli S.Kom</td>
                                        <td>fadli_78</td>
                                        <td>Kepala Sekolah</td>
                                        <td>2024-01-15</td>
                                        <td class="text-nowrap">
                                            <a href="/lihat-pengguna" class="btn btn-sm btn-primary">Show</a>
                                            <a href="/edit-pengguna" class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Alya Rahma</td>
                                        <td>alya_123</td>
                                        <td>Guru</td>
                                        <td>2024-02-20</td>
                                        <td class="text-nowrap">
                                            <a href="/edit-data-kelas" class="btn btn-sm btn-primary">Show</a>
                                            <a href="/edit-data-kelas" class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Budi Santoso</td>
                                        <td>budi_san</td>
                                        <td>Admin</td>
                                        <td>2024-03-10</td>
                                        <td class="text-nowrap">
                                            <a href="/edit-data-kelas" class="btn btn-sm btn-primary">Show</a>
                                            <a href="/edit-data-kelas" class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Citra Dewi</td>
                                        <td>citra_dewi</td>
                                        <td>Guru</td>
                                        <td>2024-04-05</td>
                                        <td class="text-nowrap">
                                            <a href="/edit-data-kelas" class="btn btn-sm btn-primary">Show</a>
                                            <a href="/edit-data-kelas" class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Dewi Lestari</td>
                                        <td>dewi_les</td>
                                        <td>Admin</td>
                                        <td>2024-05-12</td>
                                        <td class="text-nowrap">
                                            <a href="/edit-data-kelas" class="btn btn-sm btn-primary">Show</a>
                                            <a href="/edit-data-kelas" class="btn btn-sm btn-warning">Edit</a>
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
