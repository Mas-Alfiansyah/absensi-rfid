@extends('layouts.app')
@section('content')
<main>
    <div class="body-wrapper-inner">
        <div class="container-fluid">
            <h1 class="fw-bold mb-4 text-left">Tambah Pengguna</h1>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <form action="" method="POST">
                        @csrf
                        <div class="row g-4">
                            
                            <!-- Nama -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control form-control-lg" placeholder="Masukkan nama lengkap">
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Username</label>
                                <input type="text" name="username" class="form-control form-control-lg" placeholder="Masukkan username">
                            </div>

                            <!-- Role -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role</label>
                                <select name="role" class="form-select form-select-lg">
                                    <option selected disabled>Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="guru">Guru</option>
                                    <option value="siswa">Siswa</option>
                                </select>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Masukkan password">
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="text-end mt-5">
                            <a href="/pengguna" class="btn btn-outline-danger btn-lg px-4">Batal</a>
                            <button type="submit" class="btn btn-success btn-lg px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
