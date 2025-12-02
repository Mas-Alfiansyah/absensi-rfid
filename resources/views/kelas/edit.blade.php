@extends('layouts.app')
@section('title', 'Edit Kelas')
@section('content')
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="fw-bold mb-4 text-left">Edit Data Kelas</h1>

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <form action="{{ route('kelas.update', $kela->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-4">
                                <!-- Input Kelas -->
                                <div class="col-md-6">
                                    <label class="form-label">Nama Kelas</label>
                                    <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: 7A"
                                        value="{{ old('nama_kelas', $kela->nama_kelas) }}">
                                </div>

                                <!-- Input Deskripsi -->
                                <div class="col-md-12">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tuliskan deskripsi kelas...">{{ old('deskripsi', $kela->deskripsi) }}</textarea>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="text-end mt-4">
                                <a href="{{ route('kelas.index') }}" class="btn btn-outline-danger px-4">Batal</a>
                                <button type="submit" class="btn btn-success px-4">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
