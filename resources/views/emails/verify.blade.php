<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verifikasi Email</title>
    <style>
        /* sederhana style inline untuk email compatibility */
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            border-radius: 6px;
        }

        .header {
            text-align: center;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background: #1d72b8;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
        }

        .footer {
            color: #888;
            font-size: 12px;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Verifikasi Email Anda</h2>
        </div>

        <p>Halo {{ $user->name }},</p>

        <p>Terima kasih telah mendaftar. Sebelum dapat login, silakan verifikasi alamat email Anda dengan menekan tombol
            di bawah ini:</p>

        <p style="text-align:center; margin:24px 0;">
            <a class="btn" href="{{ $verificationUrl }}" target="_blank" rel="noopener">Verifikasi Email Saya</a>
        </p>

        <p>Link verifikasi ini akan berlaku selama 24 jam. Jika Anda tidak membuat akun ini, abaikan email ini.</p>

        <div class="footer">
            <p>Jika tombol tidak bekerja, salin dan tempel link ini di browser Anda:</p>
            <p style="word-break:break-all;"><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></p>
            <p>&copy; {{ date('Y') }} NamaAplikasi Anda</p>
        </div>
    </div>
</body>

</html>
