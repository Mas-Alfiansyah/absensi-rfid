@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="fw-bold mb-4 text-left">Edit Data Siswa</h1>
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        {{-- ✅ Tampilkan semua error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('siswas.update', $siswa->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-0">
                                <!-- Kolom Foto -->
                                <div class="col-md-4 d-flex align-items-center justify-content-center p-4">
                                    <div class="text-center w-100">
                                        <div class="mb-3 w-auto"
                                            style="width: 300px; height: 400px; margin: 0 auto; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 8px;">
                                            <img id="preview"
                                                src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : asset('storage/fotos/default.png') }}"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <input type="file" name="foto" class="form-control" accept="image/*"
                                            onchange="previewImage(this)">
                                        <div class="form-text mt-2">Ukuran foto maks. 2MB (jpg, jpeg, png)</div>
                                    </div>
                                </div>

                                <!-- Kolom Form -->
                                <div class="col-md-8">
                                    <div class="p-4">

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="uid" class="form-label fw-semibold">UID RFID</label>
                                                <input type="text" name="uid" class="form-control"
                                                    value="{{ old('uid', $siswa->uid) }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="nisn" class="form-label fw-semibold">NISN</label>
                                                <input type="text" name="nisn" class="form-control"
                                                    value="{{ old('nisn', $siswa->nisn) }}" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap" class="form-control"
                                                value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="tempat_lahir" class="form-label fw-semibold">Tempat
                                                    Lahir</label>
                                                <input type="text" name="tempat_lahir" class="form-control"
                                                    value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal
                                                    Lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control"
                                                    value="{{ old('tanggal_lahir', \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d')) }}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="kelas_id" class="form-label fw-semibold">Kelas</label>
                                                <select name="kelas_id" class="form-select" required>
                                                    @foreach ($kelas as $k)
                                                        <option value="{{ $k->id }}"
                                                            {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                                                            {{ $k->nama_kelas }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="jenis_kelamin" class="form-label fw-semibold">Jenis
                                                    Kelamin</label>
                                                <select name="jenis_kelamin" class="form-select" required>
                                                    <option value="L"
                                                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                                        Laki-laki</option>
                                                    <option value="P"
                                                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                                        Perempuan</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="no_wa" class="form-label fw-semibold">No. WhatsApp</label>
                                            <input type="text" id="no_wa" name="no_wa" class="form-control"
                                                value="{{ old('no_wa', $siswa->no_wa) }}" required>
                                            <small class="text-muted">Format otomatis jadi 0857-8575-1176</small>
                                        </div>

                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                            <a href="{{ route('siswas.index') }}"
                                                class="btn btn-outline-secondary me-md-2">Kembali</a>
                                            <button type="submit" class="btn btn-primary">Update Data</button>
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
        // Preview foto
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => preview.src = e.target.result;
                reader.readAsDataURL(file);
            }
        }

        // Format nomor WA otomatis
        document.addEventListener("DOMContentLoaded", function() {
            const inputWa = document.getElementById("no_wa");
            if (inputWa) {
                inputWa.addEventListener("input", function(e) {
                    let val = e.target.value.replace(/\D/g, "");
                    if (val.length > 12) val = val.slice(0, 12);
                    let formatted = val.match(/.{1,4}/g);
                    e.target.value = formatted ? formatted.join("-") : "";
                });
            }
        });
    </script>
@endsection
