@extends('layouts.app')
@section('content')
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Data Pengguna</h1>

                <!-- Card Filter -->
                <div class="card garis rounded-4 shadow-xl mb-5">
                    <div class="card-body">
                        <h5 class="mb-4">Filter</h5>
                        <form method="GET" action="{{ route('pengguna.index') }}" class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" value="{{ request('nama') }}" class="form-control"
                                    placeholder="Cari nama...">
                            </div>

                            <div class="col-md-6 d-flex justify-content-center mt-3 gap-3">
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('pengguna.index') }}" class="btn btn-danger">Reset</a>
                                <a href="{{ route('pengguna.create') }}" class="btn btn-primary">Add Data</a>
                            </div> 
                        </form>
                    </div>
                </div>

                <!-- Tabel Pengguna -->
                <div class="card shadow-sm garis rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Pengguna</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th style="width: 50px">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse($users as $index => $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ ucfirst($user->role) }}</td>
                                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                            <td class="text-nowrap">
                                                <a href="{{ route('pengguna.show', $user->id) }}"
                                                    class="btn btn-sm btn-primary">Show</a>
                                                <a href="{{ route('pengguna.edit', $user->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                <form id="form-hapus-{{ $user->id }}"
                                                    action="{{ route('pengguna.destroy', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="hapusPengguna({{ $user->id }})">
                                                        Hapus
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection
