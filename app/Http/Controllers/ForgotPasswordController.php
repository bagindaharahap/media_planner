<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;
use App\Services\ActivityLogger; // Asumsi Anda menggunakan logger ini

class ForgotPasswordController extends Controller
{
    // Menampilkan Form Lupa Password
    public function showLinkRequestForm()
    {
        return view('management_akun.formrequestemail');
    }

    // Mengirim Link Reset via Email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Pastikan user aktif sebelum bisa reset password
        $user = User::where('email', $request->email)->first();
        if ($user && $user->status !== 'Aktif') {
            return back()->withErrors(['email' => 'Akun ini sedang nonaktif. Tidak dapat mereset password.']);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            ActivityLogger::log('Auth', 'forgot_password', "Meminta link reset password untuk {$request->email}");
            return back()->with('status', 'Link reset password telah dikirim ke email Anda!');
        }

        return back()->withErrors(['email' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.']);
    }

    // Menampilkan Form Reset Password
    public function showResetForm(Request $request, $token = null)
    {
        return view('management_akun.formresetpasswordbaru')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Memproses Reset Password Baru
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed', // butuh input password_confirmation
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            ActivityLogger::log('Auth', 'reset_password', "Berhasil mereset password untuk {$request->email}");
            return redirect()->route('login')->with('success', 'Password Anda berhasil diubah! Silakan login.');
        }

        return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kedaluwarsa.']);
    }
}