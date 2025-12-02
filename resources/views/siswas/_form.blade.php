@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="fw-bold mb-4 text-left">Tambah Data Kelas</h1>
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <form action="{{ route('siswas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-0">
                                <!-- Kolom Foto (di dalam form) -->
                                <div class="col-md-4 bg-light d-flex align-items-center justify-content-center p-4">
                                    <div class="text-center w-100">
                                        <div class="mb-3" style="width: 300px; height: 400px; margin: 0 auto; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border: 2px dashed #dee2e6;">
                                            <img id="preview" src="default.png" 
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <input type="file" name="foto" class="form-control" 
                                            accept="image/*" onchange="previewImage(this)">
                                        <div class="form-text mt-2">Ukuran foto: 300x300 pixels</div>
                                    </div>
                                </div>
                                
                                <!-- Kolom Form -->
                                <div class="col-md-8">
                                    <div class="p-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="uid" class="form-label fw-semibold">UID RFID</label>
                                                    <input type="text" name="uid" class="form-control" 
                                                        value="{{ old('uid') }}" required placeholder="Masukkan UID RFID">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="nisn" class="form-label fw-semibold">NISN</label>
                                                    <input type="text" name="nisn" class="form-control" 
                                                        value="{{ old('nisn') }}" required placeholder="Masukkan NISN">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap" class="form-control" 
                                                value="{{ old('nama_lengkap') }}" required placeholder="Masukkan nama lengkap">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                            <textarea name="alamat" class="form-control" rows="2" required 
                                                    placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir</label>
                                                    <input type="text" name="tempat_lahir" class="form-control" 
                                                        value="{{ old('tempat_lahir') }}" required placeholder="Masukkan tempat lahir">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                                    <input type="date" name="tanggal_lahir" class="form-control" 
                                                        value="{{ old('tanggal_lahir') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="kelas_id" class="form-label fw-semibold">Kelas</label>
                                                    <select name="kelas_id" class="form-select" required>
                                                        <option value="">-- Pilih Kelas --</option>
                                                        @foreach ($kelas as $k)
                                                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                                                {{ $k->nama_kelas }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" class="form-select" required>
                                                        <option value="">-- Pilih --</option>
                                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="no_wa" class="form-label fw-semibold">No. WhatsApp</label>
                                            <input type="text" name="no_wa" class="form-control" 
                                                value="{{ old('no_wa') }}" required placeholder="Masukkan nomor WhatsApp">
                                        </div>
                                        
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                            <a href="{{ route('siswas.index') }}" class="btn btn-outline-secondary me-md-2">kembali</a>
                                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi preview gambar dengan ukuran tetap
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = "https://placehold.co/300x300?text=Upload+Foto";
            }
        }
    </script>
@endsection
