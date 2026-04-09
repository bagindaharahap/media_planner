<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

class LogFailedLogin
{
    public function handle(Failed $event)
    {
        $email = $event->credentials['email'] ?? 'Unknown';
        
        // Ambil semua admin
        $admins = User::where('role', 'admin')->orWhere('role', 'Admin')->get();
        
        // Kirim Notifikasi
        Notification::send($admins, new SystemNotification(
            'Security Alert',
            "Percobaan login gagal terdeteksi untuk email: {$email}.",
            'error',
            route('logs.index')
        ));
    }
}