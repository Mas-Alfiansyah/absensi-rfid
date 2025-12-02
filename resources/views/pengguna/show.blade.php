@extends('layouts.app')
@section('content')
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <!-- Card Profil -->
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden p-4">

                    <!-- Sampul -->
                    <div class="position-relative text-center">
                        <img src="../assets/images/backgrounds/user-info.jpg" alt="Cover" class="w-100 rounded-4"
                            style="object-fit: cover; height: 250px;">

                        <!-- Foto Profil di tengah bawah -->
                        <div class="position-absolute start-50 translate-middle" style="bottom: -150px;">
                            <img src="../assets/images/profile/user-1.jpg" alt="Foto Profil"
                                class="rounded-circle border border-white shadow" width="150" height="150">
                        </div>
                    </div>

                    <!-- Profil Info -->
                    <div class="text-center mt-5 pt-5">
                        <h3 class="fw-bold mb-4">{{ $pengguna->name }}</h3>
                    </div>

                    <!-- Detail Info -->
                    <div class="list-group list-group-flush mb-4">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Name:</strong> {{ $pengguna->name }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Username:</strong> {{ $pengguna->username }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Role:</strong> {{ $pengguna->role }}</span>
                        </div>
                        {{-- <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Email:</strong> rachel@callme.io</span>
                        </div> --}}
                        {{-- <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Password:</strong> ********</span>
                        </div> --}}
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Tanggal Dibuat:</strong> {{ $pengguna->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="text-center">
                        <a href="{{ route('pengguna.index') }}" class="btn btn-outline-danger px-4">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
