@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Scan</h1>

                <!-- Card Input Scan -->
                <div class="card garis shadow-md rounded-4 mb-5">
                    <div class="card-body p-4">
                        <div id="alertBox"></div>
                        <label for="scanInput" class="form-label fw-semibold">Scan atau Masukkan Kode:</label>
                        <form id="scanForm">
                            @csrf
                            <input type="text" name="uid" id="uid" class="form-control"
                                placeholder="Tempelkan Kartu RFID" autofocus>
                        </form>
                        <a href="{{ route('scan.inputManual') }}" class="btn btn-warning mt-3">
                            Input Manual
                        </a>

                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="card garis shadow-md rounded-4">
                    <div class="card-body">
                        <h4 class="mb-4">Data Scan Absensi</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover" id="absenTable">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Suara -->
    <audio id="successSound" src="{{ asset('sounds/success.mp3') }}"></audio>
    <audio id="errorSound" src="{{ asset('sounds/error.mp3') }}"></audio>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            function loadAbsens() {
                $.get("{{ route('scan.list') }}", function(data) {
                    let rows = "";
                    data.forEach(a => {
                        let statusBadge = '-';
                        if (a.status === 'hadir') {
                            statusBadge = `<span class="badge bg-success">Hadir</span>`;
                        } else if (a.status === 'lambat') {
                            statusBadge = `<span class="badge bg-warning text-black">Lambat</span>`;
                        } else if (a.status === 'sakit') {
                            statusBadge = `<span class="badge bg-primary">Sakit</span>`;
                        } else if (a.status === 'izin') {
                            statusBadge = `<span class="badge bg-primary">Izin</span>`;
                        } else if (a.status === 'alpha') {
                            statusBadge = `<span class="badge bg-danger">Alpha</span>`;
                        } else if (!a.status) {
                            statusBadge = `<span class="badge bg-secondary">Belum Absen</span>`;
                        }

                        rows += `
                    <tr class="text-center">
                        <td>${a.siswa?.nama_lengkap ?? '-'}</td>
                        <td>${a.siswa?.kelas?.nama_kelas ?? '-'}</td>
                        <td>${a.tanggal}</td>
                        <td>${a.jam_masuk ?? '-'}</td>
                        <td>${a.jam_keluar ?? '-'}</td>
                        <td>${statusBadge}</td>
                    </tr>`;
                    });

                    $("#absenTable tbody").html(rows);
                });
            }

            loadAbsens();
            setInterval(loadAbsens, 5000);

            // ==============================
            // Auto-submit 0,1 detik
            // ==============================
            let uidTimer;
            $("#uid").on("input", function() {
                clearTimeout(uidTimer);
                uidTimer = setTimeout(function() {
                    if ($("#uid").val().trim() !== "") {
                        $("#scanForm").submit();
                    }
                }, 100); // 0,1 detik
            });

            // Fungsi untuk menampilkan alert dengan timer
            function showAlert(message, type = "success") {
                let alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
        </div>
    `;
                $("#alertBox").html(alertHtml);

                // Timer: hilang setelah 3 detik
                setTimeout(() => {
                    $(".alert").fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 3000);
            }


            // Submit form scan
            $("#scanForm").on("submit", function(e) {
                e.preventDefault();
                $.post("{{ route('scan.submit') }}", $(this).serialize(), function(res) {
                    showAlert(res.success, "success");
                    document.getElementById("successSound").play();
                    loadAbsens();
                    $("#uid").val("").focus();
                }).fail(function(err) {
                    let res = err.responseJSON;
                    showAlert(res.error, "danger");
                    document.getElementById("errorSound").play();
                    $("#uid").val("").focus();
                });
            });

            // ==============================
            // Load siswa belum absen ke modal input manual
            // ==============================
            $('#manualModal').on('show.bs.modal', function() {
                $.get("{{ route('scan.siswaBelumAbsen') }}", function(data) {
                    let options = "";
                    data.forEach(s => {
                        options +=
                            `<option value="${s.id}">${s.nama_lengkap} - ${s.kelas?.nama_kelas ?? ''}</option>`;
                    });
                    $("#siswa_id").html(options);
                });
            });

            // Submit form manual
            $("#manualForm").on("submit", function(e) {
                e.preventDefault();
                $.post("{{ route('scan.manual') }}", $(this).serialize(), function(res) {
                    showAlert(res.success, "success");
                    document.getElementById("successSound").play();
                    loadAbsens();
                    $("#manualModal").modal('hide');
                }).fail(function(err) {
                    let res = err.responseJSON;
                    showAlert(res.error ?? "Gagal input manual", "danger");
                    document.getElementById("errorSound").play();
                });
            });
        });
    </script>
@endsection
