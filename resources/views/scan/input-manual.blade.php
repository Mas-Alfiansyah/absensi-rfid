@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Input Manual</h1>

                <!-- Card Input Scan -->
                <div class="card garis shadow-md rounded-4 mb-5 p-4">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">Filter nama</label>
                            <input type="text" id="filterNama" class="form-control" placeholder="Cari nama siswa...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Filter kelas</label>
                            <input type="text" id="filterKelas" class="form-control" placeholder="Cari kelas...">
                        </div>
                        <div class="col-md-6  mt-3 gap-3">
                            <a href="{{ route('scan.index') }}" class="btn btn-outline-danger mt-3">
                                Kembali
                            </a>
                        </div>
                    </div>

                </div>
                <div id="alertBox"></div>
                <!-- Tabel Data -->
                <div class="card garis shadow-md rounded-4">
                    <div class="card-body">
                        <h4 class="mb-4">Data Input Manual</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover" id="siswaTable">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th style="width: 50px">No</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Pilih Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($siswas as $s)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $s->nama_lengkap }}</td>
                                            <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                                            <td>
                                                <select class="form-select statusSelect" data-id="{{ $s->id }}">
                                                    <option value="sakit">Sakit</option>
                                                    <option value="izin">Izin</option>
                                                    <option value="alpha">Alpha</option>
                                                </select>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-primary simpanBtn"
                                                    data-id="{{ $s->id }}">Simpan</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
            // Filter
            $("#filterNama, #filterKelas").on("keyup", function() {
                let nama = $("#filterNama").val().toLowerCase();
                let kelas = $("#filterKelas").val().toLowerCase();

                $("#siswaTable tbody tr").filter(function() {
                    let textNama = $(this).find("td:nth-child(1)").text().toLowerCase();
                    let textKelas = $(this).find("td:nth-child(2)").text().toLowerCase();
                    $(this).toggle(textNama.indexOf(nama) > -1 && textKelas.indexOf(kelas) > -1);
                });
            });

            // Fungsi showAlert
            function showAlert(message, type = "success") {
                let alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
            </div>
        `;
                $("#alertBox").html(alertHtml);
                setTimeout(() => {
                    $(".alert").fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            // Simpan per siswa
            $(document).on("click", ".simpanBtn", function() {
                let id = $(this).data("id");
                let status = $(`.statusSelect[data-id='${id}']`).val();

                $.post("{{ route('scan.inputManual.simpan') }}", {
                    _token: "{{ csrf_token() }}",
                    siswa_id: id,
                    status: status
                }, function(res) {
                    showAlert(res.success, "success");
                    document.getElementById("successSound").play();
                }).fail(function(err) {
                    let res = err.responseJSON;
                    showAlert(res.error ?? "Gagal menyimpan absensi", "danger");
                    document.getElementById("errorSound").play();
                });
            });
        });
    </script>
@endsection
