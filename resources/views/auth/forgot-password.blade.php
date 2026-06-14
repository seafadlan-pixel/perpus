<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Lentera Pustaka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }

        .card-wrap {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.35);
            width: 100%;
            max-width: 480px;
            overflow: hidden;
        }

        /* ---- Header ---- */
        .card-header-custom {
            background: linear-gradient(135deg, #0f172a, #1e3a5f);
            padding: 36px 40px 28px;
            text-align: center;
        }
        .lock-icon {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.12);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 16px;
            border: 2px solid rgba(255,255,255,0.2);
        }
        .card-header-custom h1 {
            color: white;
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .card-header-custom p {
            color: #94a3b8;
            font-size: 0.875rem;
            margin: 0;
        }

        /* ---- Body ---- */
        .card-body-custom { padding: 32px 40px 36px; }

        .info-box {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 12px;
            padding: 18px 20px;
            margin-bottom: 24px;
            display: flex;
            gap: 14px;
            align-items: flex-start;
        }
        .info-box .info-icon { font-size: 1.4rem; flex-shrink: 0; margin-top: 2px; }
        .info-box p { margin: 0; font-size: 0.875rem; color: #0c4a6e; line-height: 1.6; }
        .info-box strong { color: #0369a1; }

        .steps-title {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #475569;
            margin-bottom: 14px;
        }

        .step-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        .step-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #0f172a;
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .step-text { font-size: 0.875rem; color: #334155; line-height: 1.6; }
        .step-text strong { color: #0f172a; }

        .divider { border-top: 1px solid #f1f5f9; margin: 24px 0; }

        /* Contact cards */
        .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px; }
        .contact-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
            display: block;
        }
        .contact-card:hover { background: #f1f5f9; border-color: #cbd5e1; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .contact-card .contact-icon { font-size: 1.5rem; margin-bottom: 6px; }
        .contact-card .contact-label { font-size: 0.72rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 2px; }
        .contact-card .contact-value { font-size: 0.82rem; font-weight: 600; color: #0f172a; }

        .btn-back {
            display: block;
            width: 100%;
            padding: 12px;
            background: #0f172a;
            color: white;
            border: none;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: background 0.2s, transform 0.15s;
        }
        .btn-back:hover { background: #1e293b; color: white; transform: translateY(-1px); }

        .back-link {
            text-align: center;
            margin-top: 16px;
            font-size: 0.85rem;
            color: #94a3b8;
        }
        .back-link a { color: #3b82f6; text-decoration: none; font-weight: 500; }
        .back-link a:hover { text-decoration: underline; }

        @media (max-width: 480px) {
            .card-header-custom { padding: 28px 24px 22px; }
            .card-body-custom { padding: 24px 24px 28px; }
            .contact-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="card-wrap">
    <!-- Header -->
    <div class="card-header-custom">
        <div class="lock-icon">🔐</div>
        <h1>Lupa Password?</h1>
        <p>Jangan khawatir, kami akan bantu kamu</p>
    </div>

    <!-- Body -->
    <div class="card-body-custom">

        <!-- Info box -->
        <div class="info-box">
            <div class="info-icon">ℹ️</div>
            <p>
                Sistem perpustakaan ini tidak menggunakan email untuk reset password.
                Silakan <strong>datang langsung ke Admin Perpustakaan</strong>
                atau hubungi admin melalui kontak di bawah untuk meminta password baru.
            </p>
        </div>

        <!-- Steps -->
        <div class="steps-title">📋 Cara Reset Password</div>

        <div class="step-item">
            <div class="step-number">1</div>
            <div class="step-text">
                <strong>Siapkan identitasmu</strong> — nama lengkap dan alamat email yang digunakan saat mendaftar.
            </div>
        </div>
        <div class="step-item">
            <div class="step-number">2</div>
            <div class="step-text">
                <strong>Hubungi Admin Perpustakaan</strong> secara langsung di ruang perpustakaan, atau via kontak di bawah.
            </div>
        </div>
        <div class="step-item">
            <div class="step-number">3</div>
            <div class="step-text">
                Admin akan <strong>memverifikasi identitasmu</strong> dan menetapkan password baru untukmu.
            </div>
        </div>
        <div class="step-item">
            <div class="step-number">4</div>
            <div class="step-text">
                <strong>Login kembali</strong> menggunakan password baru dan segera ganti ke password pilihanmu.
            </div>
        </div>

        <div class="divider"></div>

        <!-- Contact -->
        <div class="steps-title">📞 Hubungi Admin</div>
        <div class="contact-grid">
            <div class="contact-card">
                <div class="contact-icon">🏫</div>
                <div class="contact-label">Lokasi</div>
                <div class="contact-value">Ruang Perpustakaan</div>
            </div>
            <div class="contact-card">
                <div class="contact-icon">⏰</div>
                <div class="contact-label">Jam Layanan</div>
                <div class="contact-value">Senin–Jumat, 07.00–15.00</div>
            </div>
        </div>

        <a href="{{ route('login') }}" class="btn-back">← Kembali ke Halaman Login</a>

        <div class="back-link">
            Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </div>
</div>

</body>
</html>
