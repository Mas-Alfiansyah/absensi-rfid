@extends('layouts.app')

@section('title', 'Lihat Alumni')

@section('content')
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="fw-bold mb-4 text-left">Lihat Data Alumni</h1>
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="row g-0">
                            <!-- Kolom Foto -->
                            <div class="col-md-4 d-flex align-items-center justify-content-center p-4">
                                <div class="text-center w-100">
                                    <div class="mb-3 w-auto"
                                        style="width: 300px; height: 400px; margin: 0 auto; overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 8px;">
                                        <img id="preview" src="{{ asset('storage/' . $siswa->foto) }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="form-text mt-2">Ukuran foto: 300x300 pixels</div>
                                </div>
                            </div>

                            <!-- Kolom Form -->
                            <div class="col-md-8">
                                <div class="p-4">
                                    <div class="mb-3">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><strong>UID :</strong> {{ $siswa->uid }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><strong>NISN :</strong> {{ $siswa->nisn }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><strong>Nama Lengkap :</strong> {{ $siswa->nama_lengkap }}</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><strong>Alamat :</strong> {{ $siswa->alamat }}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <div
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span><strong>TETALA:</strong> {{ $siswa->tempat_lahir }},
                                                        {{ $siswa->tanggal_lahir }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><strong>Kelas Terakhir :</strong>
                                                {{ $siswa->kelas_terakhir ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><strong>Tahun Lulus :</strong>
                                                {{ $siswa->tahun_lulus ?? '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><strong>Jenis kelamin :</strong>{{ $siswa->jenis_kelamin }}</span>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><strong>No WhatsApp :</strong> {{ $siswa->no_wa }}</span>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                        <a href="{{ route('alumni.index') }}"
                                            class="btn btn-outline-secondary me-md-2">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
