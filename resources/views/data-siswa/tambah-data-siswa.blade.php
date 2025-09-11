@extends('layouts.app')
@section('content')
<main>
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <h1 class="fw-bold mb-4 text-left">Tambah Data Siswa</h1>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">
                            <!-- Kolom Kiri -->
                            <div class="col-lg-8">
                                <div class="row g-3">

                                    <!-- Nama -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama" placeholder="Masukkan nama lengkap" required>
                                    </div>

                                    <!-- Kelas -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Kelas</label>
                                        <select class="form-select" name="kelas" required>
                                            <option value="">-- Pilih --</option>
                                            <option>7A</option>
                                            <option>7B</option>
                                            <option>8A</option>
                                            <option>8B</option>
                                            <option>9A</option>
                                        </select>
                                    </div>

                                    <!-- NISN -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">NISN</label>
                                        <input type="text" class="form-control" name="nisn" placeholder="Masukkan NISN" required>
                                    </div>

                                    <!-- Alamat -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Alamat</label>
                                        <textarea class="form-control" name="alamat" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                                    </div>

                                    <!-- Tetala -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tempat, Tanggal Lahir</label>
                                        <input type="text" class="form-control" name="tetala" placeholder="Contoh: Jakarta, 2008-05-15" required>
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                                        <select class="form-select" name="jk" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>

                                    <!-- WA Ortu -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold">WA Ortu</label>
                                        <input type="text" class="form-control" name="wa_ortu" placeholder="08xxxxxxxxxx" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan (Foto) -->
                            <div class="col-lg-4 text-center">
                                <label class="form-label fw-semibold d-block">Foto 3x4</label>
                                <div class="border rounded p-2 d-inline-block shadow-sm" style="width: 120px; height: 160px;">
                                    <img id="preview" src="https://via.placeholder.com/120x160.png?text=3x4"
                                        alt="Preview Foto" class="img-fluid rounded" style="object-fit: cover; width: 100%; height: 100%;">
                                </div>
                                <input type="file" class="form-control mt-3" name="foto" accept="image/*" required>
                                <small class="text-muted">Upload ukuran 3x4 (jpg/png)</small>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="text-end mt-4">
                            <a href="/data-siswa" class="btn btn-outline-danger px-4">Kembali</a>
                            <button type="submit" class="btn btn-success px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Script Preview Foto -->
<script>
    document.querySelector('input[name="foto"]').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endsection
