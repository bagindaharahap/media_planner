<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\ActivityLogger;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLogin()
    {
        // Jika sudah login, langsung arahkan ke dashboard
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        
        return view('login');
    }

    /**
     * Proses login pengguna (Manual dengan Email & Password).
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // 2. Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan dalam sistem.',
            ])->withInput($request->except('password'));
        }

        // 3. Cek Status User (PENTING: Cek sebelum Auth::attempt)
        if ($user->status !== 'Aktif') {
            return back()->withErrors([
                'email' => 'Akun Anda sedang nonaktif. Silakan hubungi administrator.',
            ])->withInput($request->except('password'));
        }

        // 4. Proses Autentikasi
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Catat log aktivitas login
            ActivityLogger::log('Auth', 'login', 'Login manual ke sistem');
            
            return $this->redirectBasedOnRole();
        }

        // Jika password salah
        return back()->withErrors([
            'password' => 'Password yang Anda masukkan salah.',
        ])->withInput($request->except('password'));
    }

    /**
     * Proses login cepat menggunakan ID User (Untuk halaman "Pilih Akun").
     */
    public function loginAsUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->status !== 'Aktif') {
            return back()->withErrors(['error' => 'Akun ini sedang nonaktif.']);
        }

        Auth::login($user);
        request()->session()->regenerate();

        // Catat log aktivitas untuk login cepat
        ActivityLogger::log('Auth', 'login', 'Login cepat (Quick Login) ke sistem');

        return $this->redirectBasedOnRole(); // Menggunakan fungsi redirect sentral agar aman
    }
    
    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        // Catat log aktivitas logout SEBELUM sesi dihancurkan
        if (Auth::check()) {
            ActivityLogger::log('Auth', 'logout', 'Logout dari sistem');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Logika pengalihan berdasarkan role atau status.
     */
    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        // Keamanan tambahan: Jika user statusnya tidak aktif
        if ($user->status !== 'Aktif') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Sesi dihentikan. Akun Anda tidak aktif.'
            ]);
        }

        // Redirect berdasarkan role
        if ($user->role === 'admin' || $user->role === 'Admin') {
            // Jika admin, Anda bisa mengarahkannya ke halaman spesifik admin 
            // misalnya route('users.index') atau tetap ke route('dashboard')
            return redirect()->route('dashboard'); 
        }

        // User biasa
        return redirect()->route('dashboard');
    }
}