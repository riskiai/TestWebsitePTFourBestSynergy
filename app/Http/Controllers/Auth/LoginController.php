<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login() {
        return view('auth.login');
    }

    public function loginProsess(Request $request) {
        // Validasi input hanya berdasarkan username dan password
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Cek apakah user ditemukan dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Cek role apakah admin
            if ($user->role->role_name === 'admin') {
                Auth::login($user); // Login user
                return redirect()->route('dashboard')->with('success', 'Berhasil Login');
            } else {
                return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Username atau password salah.');
        }
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('success', 'Berhasil Logout');
    }
}
