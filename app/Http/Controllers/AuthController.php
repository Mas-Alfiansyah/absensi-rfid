<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,kepala sekolah,guru agama,guru matematika',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Validasi role
            $allowedRoles = ['admin', 'kepala sekolah', 'guru agama', 'guru matematika'];

            if (!in_array($user->role, $allowedRoles)) {
                Auth::logout();
                return back()->with('error', 'Role tidak valid, akses ditolak.');
            }

            // Validasi tambahan: pastikan role yang dipilih di form sesuai dengan role di database
            if ($request->role !== $user->role) {
                Auth::logout();
                return back()->with('error', 'Role yang dipilih tidak sesuai dengan akun.');
            }

            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
