@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<div class="container p-3" style="margin-top: 20rem">
    <h4>Detail Kelas</h4>
    <div class="mb-3">
        <strong>Nama Kelas:</strong> {{ $kela->nama_kelas }}
    </div>
    <div class="mb-3">
        <strong>Deskripsi:</strong> {{ $kela->deskripsi }}
    </div>
    <a href="{{ route('kelas.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
