@extends('layouts.app')
@section('content')
    <!-- Bagian Main -->
    <main>
        <div class="body-wrapper-inner">
            <div class="container-fluid">
                <h1 class="text-left fw-bold mb-4">Data Siswa</h1>

                <!-- Card Filter -->
                <div class="card garis shadow-md rounded-4 mb-5">
                    <div class="card-body">
                        <h5 class="mb-4">Filter</h5>
                        <form action="{{ route('siswas.index') }}" method="GET" class="row g-2 align-items-end">
                            <!-- Filter Nama -->
                            <div class="col-md-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                                    placeholder="Cari nama...">
                            </div>

                            <!-- Filter Kelas -->
                            <div class="col-md-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas_id" class="form-select">
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->id }}"
                                            {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tombol -->
                            <div class="col-md-4 d-flex justify-content-center mt-3 gap-3">
                                <button type="submit" class="btn btn-success">Filter</button>
                                <a href="{{ route('siswas.index') }}" class="btn btn-danger">Reset</a>
                                <a href="{{ route('siswas.create') }}" type="button" class="btn btn-primary">Tambah
                                    Data</a>
                                @if (request('kelas_id'))
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalTransisi">
                                        Opsi Transisi
                                    </button>
                                @else
                                    <button type="button" class="btn btn-secondary" disabled
                                        title="Pilih Kelas terlebih dahulu">
                                        Opsi Transisi
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Bagian Form Bulk Action -->


                <!-- Tabel Absensi -->
                <div class="card garis shadow-md rounded-4">
                    <div class="card-body">
                        <h5 class="mb-4">Data Siswa</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th class="text-center" style="width: 40px;"><input type="checkbox" id="checkAll"
                                                {{ request('kelas_id') ? 'checked' : '' }}></th>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>NISN</th>
                                        <th>Alamat</th>
                                        <th>Tetala</th>
                                        <th>L/P</th>
                                        <th>WA Ortu</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse($siswas as $siswa)
                                        <tr>
                                            <td class="text-center"><input type="checkbox" name="student_ids[]"
                                                    value="{{ $siswa->id }}" class="rowCheckbox"
                                                    {{ request('kelas_id') ? 'checked' : '' }}></td>
                                            <td>{{ $siswas->firstItem() + $loop->index }}</td>
                                            <td>{{ $siswa->nama_lengkap }}</td>
                                            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                                            <td>{{ $siswa->nisn }}</td>
                                            <td>{{ $siswa->alamat }}</td>
                                            <td>{{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir }}</td>
                                            <td>{{ $siswa->jenis_kelamin }}</td>
                                            <td>{{ $siswa->no_wa }}</td>
                                            <td class="text-nowrap">
                                                <a href="{{ route('siswas.show', $siswa->id) }}"
                                                    class="btn btn-sm btn-warning">Lihat</a>
                                                <a href="{{ route('siswas.edit', $siswa->id) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('siswas.destroy', $siswa->id) }}" method="POST"
                                                    style="display:inline-block;" id="form-hapus-{{ $siswa->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        onclick="hapusPengguna({{ $siswa->id }})">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @include('partials.pagination-bottom', ['data' => $siswas])
                    </div>
                </div>
            </div>
        </div>
        <!-- End Table -->
        </div>
        </div>
    </main>

    <script>
        document.getElementById('checkAll').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.rowCheckbox');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        function toggleTargetClassModal() {
            // Logic inside Modal
            var action = document.querySelector('input[name="action_type_modal"]:checked').value;
            var targetDiv = document.getElementById('modalTargetClassDiv');
            var targetSelect = document.getElementById('modalTargetClass');

            if (action === 'graduate') {
                targetDiv.style.display = 'none';
                targetSelect.disabled = true;
                targetSelect.value = "";
            } else {
                targetDiv.style.display = 'block';
                targetSelect.disabled = false;
            }
        }
    </script>
    </main>

    <!-- Modal Transisi (Updated) -->
    <div class="modal fade" id="modalTransisi" tabindex="-1" aria-labelledby="modalTransisiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTransisiLabel">Opsi Transisi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Terapkan aksi untuk siswa yang <strong>dicentang</strong>:</p>

                    <!-- Form Controls connected to the main form via JS or just Put inputs here and append to main form on submit? -->
                    <!-- Easiest: The inputs here are technically outside the form #bulkForm.
                                             We should put these inputs INSIDE #bulkForm? No, #bulkForm wraps the table.
                                             We can make the button "Simpan" in this modal submit #bulkForm, but we need to inject the extra data (action_type, target_kelas_id) into #bulkForm.
                                        -->

                    <div class="mb-3">
                        <label class="form-label d-block">Pilih Aksi</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="action_type_modal" id="optPromote"
                                value="promote" checked onchange="toggleTargetClassModal()">
                            <label class="form-check-label" for="optPromote">Simpan ke Kelas Tujuan</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="action_type_modal" id="optGraduate"
                                value="graduate" onchange="toggleTargetClassModal()">
                            <label class="form-check-label" for="optGraduate">Luluskan (Alumni)</label>
                        </div>
                    </div>

                    <div class="mb-3" id="modalTargetClassDiv">
                        <label class="form-label">Kelas Tujuan</label>
                        <select id="modalTargetClass" class="form-select">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitBulkForm()">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitBulkForm() {
            // Collect checked checkboxes
            var selected = [];
            document.querySelectorAll('.rowCheckbox:checked').forEach(function(cb) {
                selected.push(cb.value);
            });

            if (selected.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pilih minimal satu siswa.',
                    confirmButtonColor: '#ffc107',
                    confirmButtonText: 'Oke'
                });
                return;
            }

            // Create a dynamic form
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('siswas.promote') }}";

            // CSRF Token
            var csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";
            form.appendChild(csrf);

            // Modal Values
            var actionType = document.querySelector('input[name="action_type_modal"]:checked').value;
            var targetClass = document.getElementById('modalTargetClass').value;

            // Validation
            if (actionType === 'promote' && !targetClass) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silakan pilih Kelas Tujuan untuk kenaikan kelas.',
                    confirmButtonColor: '#ffc107'
                });
                return;
            }

            // Append Action and Target
            var inputAction = document.createElement('input');
            inputAction.type = 'hidden';
            inputAction.name = 'action_type';
            inputAction.value = actionType;
            form.appendChild(inputAction);

            var inputTarget = document.createElement('input');
            inputTarget.type = 'hidden';
            inputTarget.name = 'target_kelas_id';
            inputTarget.value = targetClass;
            form.appendChild(inputTarget);

            // Append Student IDs
            selected.forEach(function(id) {
                var inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'student_ids[]';
                inputId.value = id;
                form.appendChild(inputId);
            });

            // Confirm with SweetAlert2
            var actionText = actionType === 'promote' ? 'menaikkan kelas' : 'meluluskan';
            Swal.fire({
                title: 'Konfirmasi Transisi',
                text: "Anda akan " + actionText + " " + selected.length +
                    " siswa yang dipilih. Proses ini akan memperbarui data siswa.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Proses!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.body.appendChild(form);
                    form.submit();
                } else {
                    // Clean up form if not submitted
                    form.remove();
                }
            });
        }
    </script>
@endsection
