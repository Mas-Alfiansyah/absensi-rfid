@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="mb-4 text-left fw-bold">Dashboard</h1>
                <!-- Card Statistik -->
                <div class="row g-4 mb-2">
                    <div class="col-md-4">
                        <div class="card bg-biru-card text-center p-4">
                            <h5 class="text-black">Total Siswa</h5>
                            <h2 class="fw-bold text-primary">120</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-ijo-card text-center p-4">
                            <h5 class="text-black">Total Absen</h5>
                            <h2 class="fw-bold text-success">95</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-merah-card text-center p-4">
                            <h5 class="text-black">Belum Absen</h5>
                            <h2 class="fw-bold text-danger">25</h2>
                        </div>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <h4 class="mb-4">Data Absensi Hari Ini</h4>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
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
                                        <td>07:00</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-success">Hadir</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Bunga Citra</td>
                                        <td>7B</td>
                                        <td>07:15</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-warning text-dark">Terlambat</span></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Candra Wijaya</td>
                                        <td>8A</td>
                                        <td>06:55</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-success">Hadir</span></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Dewi Anggraini</td>
                                        <td>9A</td>
                                        <td>07:20</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-warning text-dark">Terlambat</span></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Eko Saputra</td>
                                        <td>8B</td>
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
