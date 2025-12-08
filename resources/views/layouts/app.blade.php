<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sekolah App')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/LOGO AMT.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        /* Style untuk menu aktif */
        .sidebar-item.active .sidebar-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            border-radius: 8px;
            margin: 2px 8px;
        }

        .sidebar-item.active .sidebar-link svg {
            stroke: white !important;
        }

        .sidebar-item.active .sidebar-link .hide-menu {
            color: white !important;
            font-weight: 600;
        }

        /* Style untuk menu hover */
        .sidebar-item:not(.active) .sidebar-link:hover {
            background-color: rgba(102, 126, 234, 0.1) !important;
            border-radius: 20px;
            margin: 2px 8px;
            color: green !important;
        }

        /* Style default untuk menu non-aktif */
        .sidebar-link {
            transition: all 0.3s ease;
            margin: 2px 8px;
            padding: 10px 15px !important;
        }

        .sidebar-link svg {
            transition: all 0.3s ease;
        }

        /* Improved Nested Menu Styles */
        .sidebar-item .first-level {
            background-color: #f8f9fa;
            /* Light grey for submenu */
            margin-left: 10px;
            border-radius: 8px;
            overflow: hidden;
        }

        .sidebar-item .first-level .sidebar-item .sidebar-link {
            padding-left: 20px !important;
            font-size: 0.9em;
        }

        .sidebar-item .first-level .sidebar-item.active .sidebar-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
        }
    </style>
</head>

<body>
    <!-- Wrapper utama -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar -->
        <aside class="left-sidebar">
            <!-- Profil pengguna -->
            <div class="user-profile position-relative"
                style="background: url({{ asset('assets/images/backgrounds/user-info.jpg') }}) no-repeat;">
                <div class="profile-img">
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="user"
                        class="w-100 rounded-circle overflow-hidden" />
                </div>
                <div class="close-btn cursor-pointer d-flex align-items-center justify-content-center d-xl-none end-0 p-2 
                    position-absolute sidebartoggler text-white top-0"
                    id="sidebarCollapse">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </div>
                <!-- Nama pengguna + dropdown -->
                <div class="profile-text hide-menu pt-1 dropdown">
                    <a href="javascript:void(0)"
                        class="dropdown-toggle u-dropdown w-100 text-white d-block position-relative"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-menu animated flipInY" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item d-flex gap-2" href="#">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#17a2b8"
                                stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Profil Saya
                        </a>
                        <a class="dropdown-item d-flex gap-2" href="#">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#17a2b8"
                                stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14,2 14,8 20,8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10,9 9,9 8,9" />
                            </svg>
                            Catatan Saya
                        </a>
                        <a class="dropdown-item d-flex gap-2" href="#">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#28a745"
                                stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            Kotak Masuk
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item d-flex gap-2" href="#">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffc107"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="3" />
                                <path
                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                            </svg>
                            Pengaturan Akun
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item d-flex gap-2" href="#">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc3545"
                                stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16,17 21,12 16,7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Keluar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Navigasi Sidebar -->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <span class="hide-menu">Home</span>
                    </li>

                    <!-- Dashboard -->
                    <li class="sidebar-item {{ request()->is('/') ? 'active' : '' }}">
                        <a class="sidebar-link" href="/">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9,22 9,12 15,12 15,22" />
                            </svg>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                    <!-- Scan -->
                    <li class="sidebar-item {{ request()->is('scan') || request()->is('scan/*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="/scan">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M3 7V5a2 2 0 0 1 2-2h2" />
                                <path d="M17 3h2a2 2 0 0 1 2 2v2" />
                                <path d="M21 17v2a2 2 0 0 1-2 2h-2" />
                                <path d="M7 21H5a2 2 0 0 1-2-2v-2" />
                                <line x1="7" y1="12" x2="17" y2="12" />
                            </svg>
                            <span class="hide-menu">Scan</span>
                        </a>
                    </li>

                    <!-- Jadwal -->
                    <li
                        class="sidebar-item {{ request()->is('jadwal') || request()->is('jadwal/*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="/jadwal">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                <line x1="16" y1="2" x2="16" y2="6" />
                                <line x1="8" y1="2" x2="8" y2="6" />
                                <line x1="3" y1="10" x2="21" y2="10" />
                                <path d="M8 14h.01" />
                                <path d="M12 14h.01" />
                                <path d="M16 14h.01" />
                                <path d="M8 18h.01" />
                                <path d="M12 18h.01" />
                                <path d="M16 18h.01" />
                            </svg>
                            <span class="hide-menu">Jadwal</span>
                        </a>
                    </li>

                    <!-- Absensi -->
                    <li
                        class="sidebar-item {{ request()->is('absensi') || request()->is('absensi/*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="/absensi">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <polyline points="16,11 18,13 22,9" />
                            </svg>
                            <span class="hide-menu">Absensi</span>
                        </a>
                    </li>

                    <!-- Laporan -->
                    <li
                        class="sidebar-item {{ request()->is('laporan') || request()->is('laporan/*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="/laporan">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14,2 14,8 20,8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10,9 9,9 8,9" />
                            </svg>
                            <span class="hide-menu">Laporan</span>
                        </a>
                    </li>

                    <li class="nav-small-cap">
                        <span class="hide-menu">Master Data</span>
                    </li>

                    <!-- Data Siswa -->
                    <!-- Data Siswa Dropdown -->
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                            <span class="d-flex">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                            </span>
                            <span class="hide-menu">Data Siswa</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item {{ request()->routeIs('siswas.index') ? 'active' : '' }}">
                                <a href="{{ route('siswas.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                    <span class="hide-menu">Siswa Aktif</span>
                                </a>
                            </li>
                            <li class="sidebar-item {{ request()->routeIs('alumni.index') ? 'active' : '' }}">
                                <a href="{{ route('alumni.index') }}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <span class="hide-menu">Daftar Alumni</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Data Kelas -->
                    <li class="sidebar-item {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="/kelas">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                            </svg>
                            <span class="hide-menu">Data Kelas</span>
                        </a>
                    </li>

                    <!-- Pengguna -->
                    <li
                        class="sidebar-item {{ request()->is('pengguna') || request()->is('pengguna/*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="/pengguna">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="8.5" cy="7" r="4" />
                                <polyline points="17,11 19,13 23,9" />
                            </svg>
                            <span class="hide-menu">Pengguna</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <!-- Sidebar selesai -->

        <!-- Konten utama -->
        <div class="body-wrapper">
            <!-- Header -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <line x1="3" y1="12" x2="21" y2="12" />
                                    <line x1="3" y1="6" x2="21" y2="6" />
                                    <line x1="3" y1="18" x2="21" y2="18" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                                        <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                                    </svg>
                                    <div class="notification bg-primary rounded-circle"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path
                                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                                <polyline points="22,6 12,13 2,6" />
                                            </svg>
                                            <p class="mb-0 fs-3">Pesan Baru</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="3" />
                                                <path
                                                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                                            </svg>
                                            <p class="mb-0 fs-3">Pengaturan</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <rect x="1" y="4" width="22" height="16" rx="2"
                                                    ry="2" />
                                                <line x1="1" y1="10" x2="23" y2="10" />
                                            </svg>
                                            <p class="mb-0 fs-3">Pembayaran</p>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt=""
                                        width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                                <circle cx="12" cy="7" r="4" />
                                            </svg>
                                            <p class="mb-0 fs-3">Profil Saya</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <path
                                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                                <polyline points="22,6 12,13 2,6" />
                                            </svg>
                                            <p class="mb-0 fs-3">Kotak Masuk</p>
                                        </a>
                                        @auth
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button class="btn text-danger d-flex align-items-center gap-2"
                                                    type="submit">
                                                    <svg width="20" height="20" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                                        <polyline points="16,17 21,12 16,7" />
                                                        <line x1="21" y1="12" x2="9"
                                                            y2="12" />
                                                    </svg>
                                                    Logout
                                                </button>
                                            </form>
                                        @endauth
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Header selesai -->

            <!-- Bagian Main -->
            <main>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @yield('content')
            </main>
            <!-- Main selesai -->
        </div>
        <!-- Konten utama selesai -->
    </div>

    <!-- Script JS -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script untuk highlight menu aktif -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Remove active class from all menu items first
            document.querySelectorAll('.sidebar-item').forEach(item => {
                item.classList.remove('active');
            });

            // Add active class based on current URL
            const currentPath = window.location.pathname;
            const currentRoute = "{{ request()->route()->getName() }}";

            // Check each menu item
            document.querySelectorAll('.sidebar-item').forEach(item => {
                const link = item.querySelector('a');
                if (link) {
                    const href = link.getAttribute('href');

                    // Check for exact match or route match
                    if (href === currentPath ||
                        currentPath.startsWith(href) && href !== '/' ||
                        item.classList.contains('active')) {
                        item.classList.add('active');
                    }
                }
            });

            // Special case for home/dashboard
            if (currentPath === '/' || currentPath === '/dashboard') {
                document.querySelector('.sidebar-item a[href="/"]').closest('.sidebar-item').classList.add(
                    'active');
            }
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                showConfirmButton: true,
            });
        </script>
    @endif

    <script>
        function hapusPengguna(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-hapus-' + id).submit();
                }
            });
        }
    </script>

</body>

</html>
