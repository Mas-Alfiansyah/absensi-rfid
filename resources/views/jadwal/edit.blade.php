@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Jadwal</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Hari</label>
                            <input type="text" class="form-control" value="{{ $jadwal->hari }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') }}" readonly>
                        </div>

                        <div class="row mb-3" id="jam-fields">
                            <div class="col-md-6">
                                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                                <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror" id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk', $jadwal->jam_masuk ? \Carbon\Carbon::parse($jadwal->jam_masuk)->format('H:i') : '08:00') }}">
                                @error('jam_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                                <input type="time" class="form-control @error('jam_keluar') is-invalid @enderror" id="jam_keluar" name="jam_keluar" value="{{ old('jam_keluar', $jadwal->jam_keluar ? \Carbon\Carbon::parse($jadwal->jam_keluar)->format('H:i') : '16:00') }}">
                                @error('jam_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="masuk" {{ old('status', $jadwal->status) == 'masuk' ? 'selected' : '' }}>Masuk</option>
                                <option value="libur" {{ old('status', $jadwal->status) == 'libur' ? 'selected' : '' }}>Libur</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan (Khusus Libur)</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const jamFields = document.getElementById('jam-fields');
        const jamMasuk = document.getElementById('jam_masuk');
        const jamKeluar = document.getElementById('jam_keluar');
        
        // Fungsi untuk menampilkan/menyembunyikan field jam
        function toggleJamFields() {
            if (statusSelect.value === 'libur') {
                jamFields.style.display = 'none';
                jamMasuk.removeAttribute('required');
                jamKeluar.removeAttribute('required');
            } else {
                jamFields.style.display = 'flex';
                jamMasuk.setAttribute('required', 'true');
                jamKeluar.setAttribute('required', 'true');
            }
        }
        
        // Jalankan saat halaman dimuat
        toggleJamFields();
        
        // Jalankan saat status berubah
        statusSelect.addEventListener('change', toggleJamFields);
    });
</script>
@endsection