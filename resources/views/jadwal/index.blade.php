@extends('layouts.app')

@section('title', 'Manajemen Jadwal')

@section('content')
    <main>
        <div class="content-wrapper">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Jadwal</h1>

                {{-- <div class="card garis mb-5">
                <div class="card-body">
                    <h5 class="mb-4">Waktu sekarang</h5>
                    <div class="mb-3">
                        <strong>Hari:</strong> {{ \Carbon\Carbon::now()->translatedFormat('l') }}
                    </div>
                    <div class="mb-3">
                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    </div>
                    <div class="mb-3">
                        <strong>Jam:</strong> {{ \Carbon\Carbon::now()->translatedFormat('H:i:s') }}
                    </div>
                </div>
            </div> --}}


                <div class="card garis shadow-lg rounded-4 mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-4">Daftar Jadwal</h4>
                            <div class="mb-1">
                                <h5 class="card garis py-1 px-3" id="jamSekarang"></h5>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>Hari</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($jadwals as $jadwal)
                                        <tr>
                                            <td>{{ $jadwal->hari }}</td>
                                            <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') }}</td>
                                            <td>
                                                @if ($jadwal->jam_masuk)
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_masuk)->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($jadwal->jam_keluar)
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_keluar)->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $jadwal->status == 'masuk' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($jadwal->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $jadwal->keterangan ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('jadwal.edit', $jadwal->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <iconify-icon icon="solar:pen-linear"></iconify-icon> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <p class="text-muted">
                                <small>
                                    <strong>Catatan:</strong> Sistem akan selalu menampilkan 7 hari ke depan.
                                    Besok, jadwal untuk hari ini akan terhapus dan digantikan dengan jadwal untuk hari
                                    ke-8.
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function updateJam() {
            const now = new Date();

            let h = String(now.getHours()).padStart(2, '0');
            let m = String(now.getMinutes()).padStart(2, '0');
            let s = String(now.getSeconds()).padStart(2, '0');

            document.getElementById('jamSekarang').textContent = `${h}:${m}:${s}`;
        }

        // Panggil sekali langsung, lalu tiap detik update
        updateJam();
        setInterval(updateJam, 1000);
    </script>
@endsection
