@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Scan</h1>

                <!-- Card Input Scan -->
                <div class="card shadow-lg rounded-4 mb-5">
                    <div class="card-body p-4">
                        <label for="scanInput" class="form-label fw-semibold">Scan atau Masukkan Kode:</label>
                        <input type="text" id="scanInput" class="form-control form-control-lg"
                            placeholder="Arahkan scanner atau ketik kode absen..." autofocus>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        <h4 class="mb-4">Data Scan Absensi</h4>
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
                                        <td>07:20</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-warning text-dark">Lambat</span></td>
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
                                        <td>07:25</td>
                                        <td>14:00</td>
                                        <td><span class="badge bg-warning text-dark">Lambat</span></td>
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
