@extends('layouts.app')
@section('content')
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="fw-bold mb-4 text-left">Tambah Pengguna</h1>

                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <form action="{{ route('pengguna.store') }}" method="POST">
                            @csrf
                            <div class="row g-4">

                                <!-- Nama -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control form-control-lg"
                                        placeholder="Masukkan nama lengkap">
                                </div>

                                <!-- Username -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">username</label>
                                    <input type="text" name="username" class="form-control form-control-lg"
                                        placeholder="Masukkan username">
                                </div>

                                <!-- Role -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Role</label>
                                    <select name="role" class="form-select form-select-lg">
                                        <option selected disabled>Pilih Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="kepala sekolah">Kepala Sekolah</option>
                                        <option value="guru agama">Guru Agama</option>
                                        <option value="guru matematika">Guru Matematika</option>
                                    </select>
                                </div>

                                <!-- Password -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control form-control-lg"
                                        placeholder="Masukkan password">
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="text-end mt-5 d-flex justify-content-start flex-column flex-md-row gap-2">
                                <button type="submit" class="btn btn-success btn-lg px-4">Simpan</button>
                                <a href="{{ route('pengguna.index') }}" class="btn btn-outline-danger btn-lg px-4">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
