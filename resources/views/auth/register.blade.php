@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Register</h2>
    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <div>
            <label>Nama</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Username</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <div>
            <label>Role</label>
            <select name="role" required>
                <option value="admin">Admin</option>
                <option value="kepala sekolah">Kepala Sekolah</option>
                <option value="guru agama">Guru Agama</option>
                <option value="guru matematika">Guru Matematika</option>
            </select>
        </div>
        <button type="submit">Register</button>
    </form>
</div>
@endsection
