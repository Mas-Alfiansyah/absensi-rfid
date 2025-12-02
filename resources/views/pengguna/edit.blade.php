@extends('layouts.app')
@section('content')
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">

                <!-- Card Edit Profil -->
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden p-4">

                    <!-- Sampul -->
                    <div class="position-relative text-center">
                        <img src="{{ asset('assets/images/backgrounds/user-info.jpg') }}" alt="Cover" class="w-100 rounded-4"
                            style="object-fit: cover; height: 250px;">

                        <!-- Icon Edit Sampul -->
                        <label for="editCover"
                            class="position-absolute top-0 end-0 m-3 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center"
                            style="cursor: pointer; width: 50px; height: 50px;">
                            <span class="iconify" data-icon="mdi:camera" data-width="30" data-height="30"></span>
                        </label>
                        <input type="file" id="editCover" class="d-none" accept="image/*">

                        <!-- Foto Profil di tengah bawah -->
                        <div class="position-absolute start-50 translate-middle" style="bottom: -150px;">
                            <div class="position-relative d-inline-block">
                                <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="Foto Profil"
                                    class="rounded-circle border border-white shadow" width="150"
                                    height="150">

                                <!-- Icon Edit Foto Profil -->
                                <label for="editProfile"
                                    class="position-absolute bottom-0 end-0 bg-dark text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="cursor: pointer; width: 50px; height: 50px;">
                                    <span class="iconify" data-icon="mdi:camera" data-width="26" data-height="26"></span>
                                </label>
                                <input type="file" id="editProfile" class="d-none" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <!-- Profil Info -->
                    <div class="text-center mt-5 pt-5">
                        <h3 class="fw-bold mb-4">Edit Pengguna</h3>
                    </div>

                    <!-- Form Edit Pengguna -->
                    <form action="{{ route('pengguna.update', $pengguna->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', $pengguna->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="username"
                                value="{{ old('name', $pengguna->username) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="admin" {{ $pengguna->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kepala sekolah" {{ $pengguna->role == 'kepala sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                                <option value="guru agama" {{ $pengguna->role == 'guru agama' ? 'selected' : '' }}>GuruAgama</option>
                                <option value="guru matematika"{{ $pengguna->role == 'guru matematika' ? 'selected' : '' }}>Guru Matematika</option>
                            </select>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="rachel@callme.io" required>
                        </div> --}}

                        {{-- <div class="mb-3">
                            <label class="form-label">Password <small class="text-muted">(isi jika ingin
                                    diganti)</small></label>
                            <input type="password" class="form-control" name="password" placeholder="********">
                        </div> --}}

                        <!-- Tombol Aksi -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('pengguna.index') }}" class="btn btn-outline-danger px-4">Kembali</a>
                            <button type="submit" class="btn btn-success px-4">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
