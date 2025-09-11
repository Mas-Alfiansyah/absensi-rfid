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
                                class="rounded-circle border border-3 border-white shadow" width="150" height="150">
                        </div>
                    </div>

                    <!-- Profil Info -->
                    <div class="text-center mt-5 pt-5">
                        <h3 class="fw-bold mb-4">Rachel Derek</h3>
                    </div>

                    <!-- Detail Info -->
                    <div class="list-group list-group-flush mb-4">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Username:</strong> rachelderek</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Role:</strong> Admin</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Email:</strong> rachel@callme.io</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Password:</strong> ********</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><strong>Tanggal Dibuat:</strong> 10 September 2025</span>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="text-center">
                        <a href="/pengguna" class="btn btn-outline-danger px-4">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
