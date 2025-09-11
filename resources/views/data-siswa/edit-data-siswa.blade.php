@extends('layouts.app')
@section('content')
<main>
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <h1 class="fw-bold mb-4 text-left">Edit Data Siswa</h1>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            
                            <!-- Foto -->
                            <div class="col-lg-4 text-center">
                                <div class="border rounded shadow-sm mx-auto mb-3" style="width: 260px; height: 320px;">
                                    <img src="https://via.placeholder.com/160x220.png?text=3x4" 
                                         alt="Foto Siswa" 
                                         class="img-fluid rounded"
                                         style="object-fit: cover; width: 100%; height: 100%;">
                                </div>
                                <input type="file" class="form-control" name="foto">
                                <small class="text-muted">Ukuran foto 3x4</small>
                            </div>

                            <!-- Form Data -->
                            <div class="col-lg-8">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">NISN</label>
                                        <input type="text" class="form-control" name="nisn" value="1234567890">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Nama</label>
                                        <input type="text" class="form-control" name="nama" value="Arya Pratama">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kelas</label>
                                        <select class="form-select" name="kelas">
                                            <option selected>7A</option>
                                            <option>7B</option>
                                            <option>8A</option>
                                            <option>8B</option>
                                            <option>9A</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="jk">
                                            <option selected>Laki-laki</option>
                                            <option>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat" value="Jakarta">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir" value="2008-05-15">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Alamat</label>
                                        <textarea class="form-control" rows="2" name="alamat">Jl. Merpati No. 10</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. WA Ortu</label>
                                        <input type="text" class="form-control" name="wa_ortu" value="081234567890">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="text-end mt-4">
                            <a href="/data-siswa" class="btn btn-outline-danger px-4">Batal</a>
                            <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
