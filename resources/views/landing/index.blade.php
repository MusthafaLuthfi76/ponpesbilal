<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PP Bilal bin Rabah - Landing</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>

  <!-- NAVBAR -->
  <header class="navbar">
    <div class="nav-container">
      <div class="nav-logo">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-image">
        <span class="brand">PPTQ Bilal bin Rabah</span>
      </div>

      <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle menu">
        <span class="burger"></span>
      </button>

      <nav class="nav-links" id="navLinks">
        <button class="nav-btn" data-target="#hero">Beranda</button>
        <button class="nav-btn" data-target="#about">Tentang</button>
        <button class="nav-btn" data-target="#programs">Program</button>
        <button class="nav-btn" data-target="#gallery">Galeri</button>
        <button class="nav-btn" data-target="#location">Lokasi</button>
        <a class="cta" href="{{ route('progress.index') }}">Cek Progress Hafalan</a>

      </nav>
    </div>
  </header>

  <!-- HERO -->
  <section class="hero" id="hero">
    <div class="hero-overlay"></div>
    <div class="hero-inner">
      <h1>Pondok Pesantren <span>Bilal bin Rabah</span></h1>
      <p class="lead">Mencetak Generasi Qur'ani yang Berakhlak Mulia</p>

      <div class="hero-actions">
        <button class="btn primary" data-target="#about">Lihat Profil Pesantren</button>
        <a class="cta" href="{{ route('progress.index') }}">Cek Progress Hafalan</a>

      </div>
    </div>
  </section>

  <!-- ABOUT -->
  <section class="about" id="about">
    <div class="container">
      <div class="section-header">
        <h2>Tentang Kami</h2>
        <div class="divider"></div>
      </div>

      <p class="about-text">
        Pondok Pesantren Bilal bin Rabah adalah lembaga pendidikan Islam yang fokus pada pembinaan generasi Qur'ani dengan metode tahfidz terpadu. Kami berkomitmen untuk mencetak para penghafal Al-Qur'an yang tidak hanya kuat hafalannya, tetapi juga berakhlak mulia dan memiliki wawasan luas.
      </p>

      <div class="pillars">
        <article class="card pillar">
          <div class="icon">📖</div>
          <h3>Pendidikan Al-Qur'an</h3>
          <p>Pembelajaran dan penghafalan Al-Qur'an dengan metode yang teruji dan efektif.</p>
        </article>

        <article class="card pillar">
          <div class="icon">🏆</div>
          <h3>Tahfidz 30 Juz</h3>
          <p>Target menghafal 30 juz dengan sistem monitoring yang transparan dan terukur.</p>
        </article>

        <article class="card pillar">
          <div class="icon">🤝</div>
          <h3>Adab & Akhlak</h3>
          <p>Pembinaan karakter dan akhlak mulia sesuai dengan ajaran Islam.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- PROGRAMS -->
  <section class="programs" id="programs">
    <div class="container">
      <div class="section-header">
        <h2>Program Kami</h2>
        <div class="divider"></div>
      </div>

      <div class="program-grid">

        <div class="card program-card">
          <div class="program-icon">📚</div>
          <h4>Tahfidz 1-30 Juz</h4>
          <p>Program menghafal Al-Qur'an 30 juz dengan metode terpadu dan bimbingan intensif.</p>
        </div>

        <div class="card program-card">
          <div class="program-icon">👥</div>
          <h4>Madrasah Diniyah</h4>
          <p>Pembelajaran ilmu agama komprehensif dengan kurikulum terstruktur.</p>
        </div>

        <div class="card program-card">
          <div class="program-icon">🌍</div>
          <h4>Bahasa Arab</h4>
          <p>Penguasaan bahasa Arab untuk memahami Al-Qur'an dan Hadits dengan lebih baik.</p>
        </div>

        <div class="card program-card">
          <div class="program-icon">🎯</div>
          <h4>Pembinaan Karakter</h4>
          <p>Pembentukan akhlak mulia dan kepribadian Islami yang kuat.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- GALLERY -->
  <section class="gallery" id="gallery">
    <div class="container">
      <div class="section-header">
        <h2>Galeri Kegiatan</h2>
        <div class="divider"></div>
      </div>

      <div class="gallery-grid">
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1559981525-40b0ab56ea28?w=1200&auto=format&fit=crop&q=80">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1598723106443-27f8bd0591b4?w=1200&auto=format&fit=crop&q=80">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1643429078857-d870aec6b37c?w=1200&auto=format&fit=crop&q=80">
        </div>
        <div class="gallery-item">
          <img src="https://images.pexels.com/photos/20627703/pexels-photo-20627703.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=1200">
        </div>
        <div class="gallery-item">
          <img src="https://images.pexels.com/photos/30224783/pexels-photo-30224783.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=1200">
        </div>
        <div class="gallery-item">
          <img src="https://images.pexels.com/photos/14231454/pexels-photo-14231454.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=1200">
        </div>
      </div>
    </div>
  </section>

  <!-- LOCATION -->
  <section class="location" id="location">
    <div class="container">
        <h2 class="title">Lokasi Pesantren</h2>
        <div class="divider"></div>

        <div class="location-wrapper">

            <div class="map-box">
                <iframe 
                  src="https://www.google.com/maps?q=Pondok+Pesantren+Bilal+bin+Rabah+Sukoharjo&output=embed"
                  width="100%" height="350" style="border:0;" loading="lazy">
                </iframe>

                <a href="https://share.google/hZZKzOyy7JEgUKR83"
                   class="map-button" target="_blank">
                   Buka Lokasi di Google Maps
                </a>
            </div>
        </div>
    </div>
</section>

  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="container footer-grid">

      <div>
        <div class="footer-logo">
          <img src="{{ asset('img/logo.png') }}" class="logo-image">
          <span>PP Bilal bin Rabah</span>
        </div>
        <p class="muted">Mencetak generasi Qur'ani yang berakhlak mulia</p>
      </div>

      <div>
        <h4>Kontak</h4>
        <p>Jl. Islamic Centre No. 123, Jakarta</p>
        <p>Telp: (021) 1234-5678</p>
        <p>WhatsApp: 0812-3456-7890</p>
        <p>Email: info@ppbilalbinrabah.id</p>
      </div>

      <div>
        <h4>Jam Layanan</h4>
        <p>Senin - Jumat: 08:00 - 16:00</p>
      </div>

    </div>

    <div class="footer-bottom">
      © 2024 PPTQ Bilal bin Rabah. All rights reserved.
    </div>
  </footer>

  <!-- JS -->
  <script>
    const navLinks = document.getElementById("navLinks");
    const mobileToggle = document.getElementById("mobileToggle");

    mobileToggle.onclick = () => {
      mobileToggle.classList.toggle("open");
      navLinks.classList.toggle("open");
    };

    document.querySelectorAll("[data-target]").forEach(btn => {
      btn.addEventListener("click", e => {
        const target = document.querySelector(btn.dataset.target);
        if (target) target.scrollIntoView({ behavior: "smooth" });

        navLinks.classList.remove("open");
        mobileToggle.classList.remove("open");
      });
    });
  </script>

</body>
</html>
