@extends('layouts.app')
@section('content')
<main>
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <h1 class="fw-bold mb-4 text-left">Detail Data Siswa</h1>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="row g-4">
                        
                        <!-- Foto -->
                        <div class="col-lg-4 text-center">
                            <div class="border rounded shadow-sm mx-auto" style="width: 260px; height: 320px;">
                                <img src="https://via.placeholder.com/160x220.png?text=3x4" 
                                     alt="Foto Siswa" 
                                     class="img-fluid rounded"
                                     style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                        </div>

                        <!-- Detail -->
                        <div class="col-lg-8">
                            <table class="table table-borderless table-hover">
                                <tbody>
                                    <tr>
                                        <th width="30%">NISN</th>
                                        <td>: 1234567890</td>
                                    </tr>
                                    <tr>
                                        <th>Nama</th>
                                        <td>: Arya Pratama</td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td>: 7A</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>: Jl. Merpati No. 10</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat, Tanggal Lahir</th>
                                        <td>: Jakarta, 2008-05-15</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>: Laki-laki</td>
                                    </tr>
                                    <tr>
                                        <th>WA Ortu</th>
                                        <td>: 081234567890</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="text-end mt-4">
                        <a href="/data-siswa" class="btn btn-outline-danger px-4">Kembali</a>
                        <a href="" class="btn btn-warning px-4">Edit</a>
                        <button class="btn btn-danger px-4">Hapus</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
