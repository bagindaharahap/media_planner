<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Content Planner</title>
</head>
<body style="background-color: #f8fafc; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; padding: 40px 20px; margin: 0; -webkit-font-smoothing: antialiased;">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <!-- Main Email Card -->
                <table width="100%" max-width="600" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="padding: 40px; text-align: center; border-bottom: 1px solid #f1f5f9;">
                            <div style="display: inline-block; background-color: #4f46e5; color: #ffffff; padding: 12px; border-radius: 12px; margin-bottom: 15px;">
                                <!-- Simple Lock Icon fallback -->
                                <img src="https://i.ibb.co.com/F4pWPd0q/Desain-tanpa-judul-2.png" alt="Lock" width="30" height="30" style="display: block;">
                            </div>
                            <h1 style="color: #1e293b; margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">Content Planner</h1>
                        </td>
                    </tr>
                    
                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px 40px 20px; text-align: center;">
                            <h2 style="color: #334155; margin-top: 0; font-size: 20px; font-weight: 700;">Permintaan Reset Password</h2>
                            
                            <p style="color: #64748b; font-size: 15px; line-height: 1.6; margin-bottom: 30px;">
                                Halo <strong>{{ $user->name }}</strong>,<br><br>
                                Kami menerima permintaan untuk mereset password akun Anda di sistem operasional internal. Silakan klik tombol di bawah ini untuk membuat password baru Anda.
                            </p>

                            <!-- Call to Action Button -->
                            <a href="{{ $url }}" style="display: inline-block; background-color: #4f46e5; color: #ffffff; padding: 14px 32px; text-decoration: none; border-radius: 12px; font-weight: bold; font-size: 15px;">
                                Reset Password Sekarang
                            </a>
                        </td>
                    </tr>

                    <!-- Additional Info -->
                    <tr>
                        <td style="padding: 20px 40px 40px; text-align: center;">
                            <p style="color: #94a3b8; font-size: 13px; line-height: 1.6; margin: 0;">
                                Link reset password ini hanya berlaku selama <strong>60 menit</strong>.<br>
                                Jika Anda tidak pernah melakukan permintaan ini, abaikan email ini dan akun Anda akan tetap aman.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f1f5f9; padding: 24px; text-align: center;">
                            <p style="color: #94a3b8; font-size: 12px; margin: 0; font-weight: 600;">
                                &copy; {{ date('Y') }} Content Planner (Internal System). All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
    </table>

</body>
</html>