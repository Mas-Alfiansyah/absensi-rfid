<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Saya</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
    <script src="{{ asset('assets/css/icons/tabler-icons/iconify.min.js') }}"></script>
</head>

<body>
    <!-- Wrapper utama -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar -->
        <aside class="left-sidebar">
            <!-- Profil pengguna -->
            <div class="user-profile position-relative"
                style="background: url(../assets/images/backgrounds/user-info.jpg) no-repeat;">
                <div class="profile-img">
                    <img src="../assets/images/profile/user-1.jpg" alt="user"
                        class="w-100 rounded-circle overflow-hidden" />
                </div>
                <div class="close-btn cursor-pointer d-flex align-items-center justify-content-center d-xl-none end-0 p-2 
                    position-absolute sidebartoggler text-white top-0"
                    id="sidebarCollapse">
                    <i class="ti ti-x fs-7"></i>
                </div>
                <!-- Nama pengguna + dropdown -->
                <div class="profile-text hide-menu pt-1 dropdown">
                    <a href="javascript:void(0)"
                        class="dropdown-toggle u-dropdown w-100 text-white d-block position-relative"
                        id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        Markarn Doe
                    </a>
                    <div class="dropdown-menu animated flipInY" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item d-flex gap-2" href="#"><i data-feather="user"
                                class="feather-sm text-info"></i> Profil Saya</a>
                        <a class="dropdown-item d-flex gap-2" href="#"><i data-feather="credit-card"
                                class="feather-sm text-info"></i> Catatan Saya</a>
                        <a class="dropdown-item d-flex gap-2" href="#"><i data-feather="mail"
                                class="feather-sm text-success"></i> Kotak Masuk</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item d-flex gap-2" href="#"><i data-feather="settings"
                                class="feather-sm text-warning"></i> Pengaturan Akun</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item d-flex gap-2" href="#"><i data-feather="log-out"
                                class="feather-sm text-danger"></i> Keluar</a>
                    </div>
                </div>
            </div>

            <!-- Navigasi Sidebar -->
            <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                <ul id="sidebarnav">
                    <li class="nav-small-cap">
                        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                        <span class="hide-menu">Home</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/">
                            <iconify-icon icon="solar:screencast-2-linear"></iconify-icon>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/scan">
                            <iconify-icon icon="solar:document-linear"></iconify-icon>
                            <span class="hide-menu">Scan</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/jadwal">
                            <iconify-icon icon="solar:checklist-minimalistic-linear"></iconify-icon>
                            <span class="hide-menu">Jadwal</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/absensi">
                            <iconify-icon icon="solar:checklist-minimalistic-linear"></iconify-icon>
                            <span class="hide-menu">Absensi</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/laporan">
                            <iconify-icon icon="solar:checklist-minimalistic-linear"></iconify-icon>
                            <span class="hide-menu">Laporan</span>
                        </a>
                    </li>
                    <li class="nav-small-cap">
                        <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
                        <span class="hide-menu">Master Data</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/data-siswa">
                            <iconify-icon icon="solar:user-circle-linear"></iconify-icon>
                            <span class="hide-menu">Data Siswa</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/data-kelas">
                            <iconify-icon icon="solar:user-circle-linear"></iconify-icon>
                            <span class="hide-menu">Data Kelas</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="/pengguna">
                            <iconify-icon icon="solar:layers-linear"></iconify-icon>
                            <span class="hide-menu">Pengguna</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <!-- Sidebar selesai -->

        <!-- Konten utama -->
        <div class="body-wrapper">
            <!-- Header (TETAP seperti asli, tidak diubah) -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-bell-ringing"></i>
                                    <div class="notification bg-primary rounded-circle"></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">Pesan Baru</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-settings fs-6"></i>
                                            <p class="mb-0 fs-3">Pengaturan</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-credit-card fs-6"></i>
                                            <p class="mb-0 fs-3">Pembayaran</p>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="../assets/images/profile/user-1.jpg" alt="" width="35"
                                        height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">Profil Saya</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">Kotak Masuk</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-power fs-6"></i>
                                            <p class="mb-0 fs-3">Keluar</p>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <a href="/login" class="btn btn-success">Login</a>
                </nav>
            </header>
            <!-- Header selesai -->

            <!-- Bagian Main -->
            <main>
                @yield('content')
            </main>
            <!-- Main selesai -->
        </div>
        <!-- Konten utama selesai -->
    </div>

    <!-- Script JS -->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
