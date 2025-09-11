@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Absensi </h1>

                <!-- Card Filter -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h5 class="mb-4">Filter Absensi</h5>
                        <form class="row g-2 align-items-end">
                            <!-- Filter Kelas -->
                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <select class="form-select">
                                    <option value="">-- Pilih Kelas --</option>
                                    <option>7A</option>
                                    <option>7B</option>
                                    <option>8A</option>
                                    <option>8B</option>
                                    <option>9A</option>
                                </select>
                            </div>
                            <!-- Filter Date Range -->
                            <div class="col-md-3">
                                <label class="form-label">Date Range</label>
                                <select class="form-select">
                                    <option value="">-- Pilih Range --</option>
                                    <option>Hari Ini</option>
                                    <option>Minggu Ini</option>
                                    <option>Bulan Ini</option>
                                    <option>Tahun Ini</option>
                                </select>
                            </div>
                            <!-- Filter Nama -->
                            <div class="col-md-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" placeholder="Cari nama...">
                            </div>

                            <!-- Tombol -->
                            <div class="col-md-3 d-flex justify-content-center mt-3 gap-2">
                                <button type="reset" class="btn btn-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Absensi</h5>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Arya Pratama</td>
                                        <td>7A</td>
                                        <td>2025-09-10</td>
                                        <td>07:00</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-success">Hadir</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Bunga Citra</td>
                                        <td>7B</td>
                                        <td>2025-09-10</td>
                                        <td>07:20</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-warning text-dark">Lambat</span></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Candra Wijaya</td>
                                        <td>8A</td>
                                        <td>2025-09-10</td>
                                        <td>06:55</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-success">Hadir</span></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Dewi Anggraini</td>
                                        <td>9A</td>
                                        <td>2025-09-10</td>
                                        <td>07:25</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-warning text-dark">Lambat</span></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Eko Saputra</td>
                                        <td>8B</td>
                                        <td>2025-09-10</td>
                                        <td>07:05</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-success">Hadir</span></td>
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
