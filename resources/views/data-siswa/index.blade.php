@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Data Siswa</h1>

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
                                <a href="/tambah-data-siswa" type="button" class="btn btn-primary">Tambah Data</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Siswa</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="table-primary text-center">
                                    <tr>
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
                                    <tr>
                                        <td>Arya Pratama</td>
                                        <td>7A</td>
                                        <td>1234567890</td>
                                        <td>Pakong</td>
                                        <td>Pamekasan, 2008-05-15</td>
                                        <td>L</td>
                                        <td>081234567890</td>
                                        <td class="text-nowrap">
                                            <a href="/lihat-data-siswa" class="btn btn-sm btn-warning">Lihat</a>
                                            <a href="/edit-data-siswa" class="btn btn-sm btn-primary">Edit</a>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Bunga Citra</td>
                                        <td>7B</td>
                                        <td>0987654321</td>
                                        <td>Teja</td>
                                        <td>Bandung, 2008-08-22</td>
                                        <td>P</td>
                                        <td>089876543210</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-warning">Lihat</button>
                                            <button class="btn btn-sm btn-primary">Edit</button>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Candra Wijaya</td>
                                        <td>8A</td>
                                        <td>1122334455</td>
                                        <td>Proppo</td>
                                        <td>Surabaya, 2007-11-30</td>
                                        <td>L</td>
                                        <td>081122334455</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-warning">Lihat</button>
                                            <button class="btn btn-sm btn-primary">Edit</button>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Karlina Anggraini</td>
                                        <td>9A</td>
                                        <td>5566778899</td>
                                        <td>Plakpak</td>
                                        <td>Medan, 2006-02-10</td>
                                        <td>P</td>
                                        <td>085566778899</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-warning">Lihat</button>
                                            <button class="btn btn-sm btn-primary">Edit</button>
                                            <button class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Eko Saputra</td>
                                        <td>8B</td>
                                        <td>6677889900</td>
                                        <td>Plakpak</td>
                                        <td>Yogyakarta, 2007-07-25</td>
                                        <td>L</td>
                                        <td>086677889900</td>
                                        <td class="text-nowrap">
                                            <button class="btn btn-sm btn-warning">Lihat</button>
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
