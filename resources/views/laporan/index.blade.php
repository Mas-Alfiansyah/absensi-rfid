@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Laporan </h1>

                <!-- Card Filter -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h5 class="mb-4">Filter</h5>
                        <form class="row g-2 align-items-end">
                            <!-- Filter Kelas -->
                            <div class="col-md-2">
                                <label class="form-label">Kelas</label>
                                <select class="form-select">
                                    <option value="">Pilih Kelas</option>
                                    <option>7A</option>
                                    <option>7B</option>
                                    <option>8A</option>
                                    <option>8B</option>
                                    <option>9A</option>
                                </select>
                            </div>
                            <!-- Filter Bulan -->
                            <div class="col-md-2">
                                <label class="form-label">Bulan</label>
                                <select class="form-select">
                                    <option value="">Pilih Bulan</option>
                                    <option>Januari</option>
                                    <option>Februari</option>
                                    <option>Maret</option>
                                    <option>April</option>
                                    <option>Mei</option>
                                    <option>Juni</option>
                                    <option>Juli</option>
                                    <option>Agustus</option>
                                    <option>September</option>
                                    <option>Oktober</option>
                                    <option>November</option>
                                    <option>Desember</option>
                                </select>
                            </div>
                            <!-- Filter Tahun -->
                            <div class="col-md-2">
                                <label class="form-label">Tahun</label>
                                <select class="form-select">
                                    <option value="">Pilih Tahun</option>
                                    <option>2025</option>
                                    <option>2024</option>
                                    <option>2023</option>
                                </select>
                            </div>
                            <!-- Filter Nama -->
                            <div class="col-md-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" placeholder="Cari nama...">
                            </div>

                            <!-- Tombol -->
                            <div class="col-md-3 d-flex justify-content-center mt-3 gap-2">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Laporan</h5>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Tanggal</th>
                                        <th>T Hadir</th>
                                        <th>T Alfa</th>
                                        <th>T Lambat</th>
                                        <th>T Jam Terlambat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Arya Pratama</td>
                                        <td>7A</td>
                                        <td>2025-09-10</td>
                                        <td>5</td>
                                        <td>8</td>
                                        <td>2</td>
                                        <td>00:30</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Bunga Citra</td>
                                        <td>7B</td>
                                        <td>2025-09-10</td>
                                        <td>4</td>
                                        <td>9</td>
                                        <td>3</td>
                                        <td>01:15</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Candra Wijaya</td>
                                        <td>8A</td>
                                        <td>2025-09-10</td>
                                        <td>6</td>
                                        <td>7</td>
                                        <td>1</td>
                                        <td>00:10</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Dewi Anggraini</td>
                                        <td>9A</td>
                                        <td>2025-09-10</td>
                                        <td>3</td>
                                        <td>10</td>
                                        <td>4</td>
                                        <td>01:25</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Eko Saputra</td>
                                        <td>8B</td>
                                        <td>2025-09-10</td>
                                        <td>5</td>
                                        <td>8</td>
                                        <td>2</td>
                                        <td>00:20</td>
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
