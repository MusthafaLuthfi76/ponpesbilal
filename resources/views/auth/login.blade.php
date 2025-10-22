<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Login - Sistem Informasi Pesantren</title>
    <link rel="icon" href="/favicon.ico">
    <style>
        :root { --green:#1f4a34; --green2:#254f37; --accent:#2f6d4f; --bg:#cdd9cf; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, 'Fira Sans', 'Droid Sans', 'Helvetica Neue', sans-serif; background:#cdd9cf; color:#0f1b14; }
        .hero { background: var(--green); color:#fff; padding: 36px 16px 36px; text-align:center; position:relative; box-shadow: 0 2px 0 #234f3a; }
        .hero .brand { display:flex; align-items:center; justify-content:center; gap:16px; }
        .brand img { width:72px; height:72px; object-fit:contain; }
        .brand h1 { margin:0; font-size:28px; letter-spacing:.3px; }
        .divider { height:1px; background:#2a5b43; width:88%; margin:12px auto 18px; opacity:.35; }
        .quote { color:#cfe9d7; font-size:13px; line-height:1.6; }
        .quote .arab { font-family:'Scheherazade New', serif; font-size:18px; display:block; margin-bottom:8px; }

        /* Jarak jelas antara header (nav) dan konten */
        .wrap { display:flex; justify-content:center; padding:48px 20px; }
        .container { width:100%; max-width:960px; }
        .card { width:560px; max-width:100%; margin:0 auto; background:#fff; border-radius:14px; box-shadow:0 20px 40px rgba(0,0,0,.10); padding:28px 26px; border:1px solid #e9ecea; }
        .card h2 { text-align:center; margin:0 0 18px; color:#1b3126; }
        label { font-size:13px; color:#3f5b4a; margin-bottom:6px; display:block; }
        .input { width:100%; border:1px solid #d6dfd9; background:#eef3ef; border-radius:8px; padding:12px 12px; outline:none; transition:border-color .15s, background .15s; }
        .input:focus { border-color:#2f6d4f; background:#fff; }
        .row { margin-bottom:14px; }
        .input { width:100%; border:1px solid #d6dfd9; background:#eef3ef; border-radius:8px; padding:12px 12px; outline:none; transition:border-color .15s, background .15s; }
        .input:focus { border-color:#2f6d4f; background:#fff; }
        .input-wrap{ position:relative; }
        .eye-btn{ position:absolute; right:10px; top:50%; transform:translateY(-50%); background:transparent; border:none; color:#2f6d4f; cursor:pointer; padding:4px; display:flex; align-items:center; }
        .eye-btn:focus{ outline:2px solid #cfe9d7; outline-offset:2px; }
        .submit { width:100%; border:none; border-radius:8px; padding:12px; background:linear-gradient(#224d37, #2f6d4f); color:#fff; font-weight:600; cursor:pointer; }
        .submit:hover { filter:brightness(1.06); }
        .error { color:#b00020; font-size:12px; margin-top:6px; }
        .foot { text-align:center; margin-top:8px; }
        .foot small { color:#345a45; }

        @media (max-width:640px){
            .brand img{width:56px;height:56px}
            .card{padding:22px 20px}
        }
    </style>
</head>
<body>
    <header class="hero">
        <div class="brand">
            <img src="/img/logo.png" alt="Logo" />
            <h1>Sistem Informasi Pesantren</h1>
        </div>
        <div class="divider"></div>
        <div class="quote">
            <span class="arab">وَلَقَدْ يَسَّرْنَا الْقُرْآنَ لِلذِّكْرِ فَهَلْ مِنْ مُدَّكِرٍ</span>
            <span>"Dan sesungguhnya telah Kami mudahkan Al-Qur'an untuk pelajaran, maka adakah orang yang mengambil pelajaran?"</span>
        </div>
    </header>

    <div class="wrap">
        <div class="container">
            <div class="card">
                <h2>Login</h2>
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="row">
                        <label for="nama">Masukkan Nama</label>
                        <input id="nama" name="nama" type="text" class="input" value="{{ old('nama') }}" required autofocus />
                        @error('nama')<div class="error">{{ $message }}</div>@enderror
                    </div>
                    <div class="row">
                        <label for="password">Masukkan Password</label>
                        <div class="input-wrap">
                            <input id="password" name="password" type="password" class="input" required />
                            <button id="togglePassword" type="button" class="eye-btn" aria-label="Tampilkan/Sembunyikan password">
                                <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-off" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.77 21.77 0 0 1 5.06-6.03"/><path d="M1 1l22 22"/><path d="M9.88 9.88A3 3 0 0 0 9 12c0 1.65 1.35 3 3 3 .42 0 .82-.09 1.18-.25"/></svg>
                            </button>
                        </div>
                        @error('password')<div class="error">{{ $message }}</div>@enderror
                    </div>
                    <div class="row" style="display:flex;align-items:center;gap:8px;">
                       
                     
                    </div>
                    <button class="submit" type="submit">Login</button>
                </form>
                <div class="foot">
                    <small>&copy; {{ date('Y') }} Sistem Informasi Pesantren</small>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
  const pwd = document.getElementById('password');
  const btn = document.getElementById('togglePassword');
  const eyeOpen = btn.querySelector('.eye-open');
  const eyeOff = btn.querySelector('.eye-off');
  btn?.addEventListener('click', () => {
    const isHidden = pwd.type === 'password';
    pwd.type = isHidden ? 'text' : 'password';
    eyeOpen.style.display = isHidden ? 'none' : '';
    eyeOff.style.display = isHidden ? '' : 'none';
  });
</script>
</html>