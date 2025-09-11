@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Jadwal</h1>

                <!-- Tombol Tambah Jadwal -->
                <div class="mb-4 text-end">
                    <button class="btn btn-primary btn-lg shadow" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        Tambah Jadwal
                    </button>
                </div>

                <!-- Tabel Jadwal -->
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>No</th>
                                        <th>Hari</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Senin</td>
                                        <td>07:00</td>
                                        <td>14:00</td>
                                        <td><button class="btn btn-warning btn-sm shadow" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit">✏️ Edit</button></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Selasa</td>
                                        <td>07:00</td>
                                        <td>14:00</td>
                                        <td><button class="btn btn-warning btn-sm shadow" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit">✏️ Edit</button></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Rabu</td>
                                        <td>07:00</td>
                                        <td>14:00</td>
                                        <td><button class="btn btn-warning btn-sm shadow" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit">✏️ Edit</button></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Kamis</td>
                                        <td>07:00</td>
                                        <td>14:00</td>
                                        <td><button class="btn btn-warning btn-sm shadow" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit">✏️ Edit</button></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Jumat</td>
                                        <td>07:00</td>
                                        <td>11:00</td>
                                        <td><button class="btn btn-warning btn-sm shadow" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit">✏️ Edit</button></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Sabtu</td>
                                        <td>08:00</td>
                                        <td>12:00</td>
                                        <td><button class="btn btn-warning btn-sm shadow" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit">✏️ Edit</button></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Minggu</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><button class="btn btn-warning btn-sm shadow" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit">✏️ Edit</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Jadwal -->
            <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">➕ Tambah Jadwal</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Hari</label>
                                    <input type="text" class="form-control" placeholder="Contoh: Senin">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jam Masuk</label>
                                    <input type="time" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jam Keluar</label>
                                    <input type="time" class="form-control">
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Jadwal -->
            <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title">✏️ Edit Jadwal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Hari</label>
                                    <input type="text" class="form-control" value="Senin">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jam Masuk</label>
                                    <input type="time" class="form-control" value="07:00">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jam Keluar</label>
                                    <input type="time" class="form-control" value="14:00">
                                </div>
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
