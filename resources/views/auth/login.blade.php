<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart-Absensi</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/LOGO AMT.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
    <script src="{{ asset('assets/css/icons/tabler-icons/iconify.min.js') }}"></script>
    <style>
        .alert.fade-out {
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }
        .alert.fade-out.hide {
            opacity: 0;
        }
        .text-bg-light {
            background-color: #1b7ddf !important;
        }
        .text-bg-light::before {
            content: '';
            position: absolute;
            top: 30%;
            left: 0;
            width: 100%;
            height: 70%;
            background: #ffffff;
            border-top-left-radius: 35px;
            border-top-right-radius: 35px;
            z-index: 0;
        }
        @media (max-width: 768px) {
            .text-bg-light::before {
                border-top-left-radius: 15px;
                border-top-right-radius: 15px;
            }
        }
        .form-control {
          border: 1px solid #d3d3d3;
        }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden text-bg-light min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body garis shadow-lg">
                
                <h1 class="text-center text-primary fs-9 fw-bold">LOGIN</h1>
                <!-- Tampilkan pesan success -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Tampilkan pesan error -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Tampilkan error validasi -->
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

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" class="form-control" id="exampleInputPassword1">
                  </div>
                  <div class="mb-4">
                    <label class="form-label">Role</label>
                <select name="role" required class="form-control">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kepala sekolah" {{ old('role') == 'kepala sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                    <option value="guru agama" {{ old('role') == 'guru agama' ? 'selected' : '' }}>Guru Agama</option>
                    <option value="guru matematika" {{ old('role') == 'guru matematika' ? 'selected' : '' }}>Guru Matematika</option>
                </select>
                  </div>
                  {{-- <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remeber this Device
                      </label>
                    </div>
                    <a class="text-primary fw-medium" href="./index.html">Forgot Password ?</a>
                  </div> --}}
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Login</button>
                  {{-- <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">New to MaterialPro?</p>
                    <a class="text-primary fw-medium ms-2" href="./authentication-register.html">Create an account</a>
                  </div> --}}
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <script>
        // Fungsi untuk auto dismiss alert dengan efek fade out yang mulus
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.auto-dismiss');
            
            alerts.forEach(function(alert) {
                // Tambahkan class untuk transition
                alert.classList.add('fade-out');
                
                setTimeout(function() {
                    // Trigger fade out effect
                    alert.classList.add('hide');
                    
                    // Hapus element dari DOM setelah transition selesai
                    setTimeout(function() {
                        alert.remove();
                    }, 500); // Sesuaikan dengan durasi transition (0.5s)
                }, 3000); // 3000ms = 3 detik
            });
        });
    </script>

</body>

</html>