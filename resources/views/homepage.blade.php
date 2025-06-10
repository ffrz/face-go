<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>{{ env('APP_NAME') }}</title>
  <meta name="description"
    content="{{ env('APP_NAME') }} adalah solusi digital untuk mengelola proses produksi maklun dan konveksi secara transparan, terstruktur, dan mudah diawasi — dari penyerahan bahan hingga pembayaran hasil kerja.">
  <meta name="keywords" content="">
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  @vite([])
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="./" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">{{ env('APP_NAME') }}</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Beranda</a></li>
          <li><a href="#about">Tentang</a></li>
          <li><a href="#features">Fitur</a></li>
          <li><a href="#contact">Hubungi Kami</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="{{ route('admin.auth.login') }}">Masuk</a>
      {{-- <a class="btn-getstarted" href="{{ route('admin.auth.register') }}">Daftar</a> --}}

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="section hero light-background">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-lg-1 d-flex flex-column justify-content-center order-2" data-aos="fade-up">
            <h2>Absensi Otomatis dan Akurat dengan Selfie dan Deteksi Lokasi</h2>
            <p>{{ env('APP_NAME') }} adalah sistem absensi digital berbasis wajah dan deteksi lokasi untuk sekolah,
              instansi, dan perusahaan — memastikan kehadiran real-time, akurat, dan bebas kecurangan.</p>
          </div>
          <div class="col-lg-6 order-lg-2 hero-img order-1" data-aos="zoom-out" data-aos-delay="200">
            <img src="assets/img/hero-img.jpg" class="img-fluid" style="border-radius: 10px;" alt="FaceGo Absensi">
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section about">
      <div class="container">
        <h3 class="text-center">Solusi Absensi Modern dan Terintegrasi</h3>
        <p class="mb-5 text-center">
          Dengan teknologi pengenalan wajah, {{ env('APP_NAME') }} menghilangkan risiko titip absen dan memudahkan rekap
          kehadiran harian, bulanan, hingga rekap gaji.
        </p>
        <div class="row gy-3 align-items-center">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/about-img.jpg" alt="" class="img-fluid" style="border-radius:10px;">
          </div>
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="about-content ps-lg-3 ps-0">
              <ul>
                <li>
                  <i class="bi bi-person-bounding-box"></i>
                  <div>
                    <h4>Absensi Wajah Otomatis</h4>
                    <p>Absen hanya dengan selfie, sistem akan mengenali wajah secara otomatis — tidak perlu fingerprint
                      atau tanda tangan manual.</p>
                  </div>
                </li>
                <li>
                  <i class="bi bi-geo-alt"></i>
                  <div>
                    <h4>Pelacakan Lokasi GPS</h4>
                    <p>Pastikan pengguna melakukan absen dari lokasi yang valid. Lokasi akan terekam otomatis saat absen
                      masuk dan pulang.</p>
                  </div>
                </li>
                <li>
                  <i class="bi bi-calendar-check"></i>
                  <div>
                    <h4>Rekap & Laporan Kehadiran</h4>
                    <p>Laporan hadir/tidak hadir, keterlambatan, izin, dan cuti otomatis direkap dan dapat diunduh kapan
                      saja dalam bentuk Excel/PDF.</p>
                  </div>
                </li>
                <li>
                  <i class="bi bi-people"></i>
                  <div>
                    <h4>Dashboard Admin Real-Time</h4>
                    <p>Admin dapat melihat siapa yang hadir, siapa yang belum, dan status absensi setiap karyawan atau
                      siswa secara real-time.</p>
                  </div>
                </li>
                <li>
                  <i class="bi bi-bell-fill"></i>
                  <div>
                    <h4>Notifikasi Kehadiran</h4>
                    <p>Notifikasi dikirim otomatis ke admin atau wali kelas/orang tua saat siswa melakukan absen.</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="services section light-background">
      <div class="section-title container" data-aos="fade-up">
        <h2>Manfaat Utama {{ env('APP_NAME') }}</h2>
      </div>

      <div class="container">
        <div class="row gy-4">
          <div class="col-12 col-md-3" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-shield-check icon"></i></div>
              <h4><a href="#" class="stretched-link">Aman & Anti Titip Absen</a></h4>
              <p>Wajah tidak bisa dipalsukan. Sistem validasi berganda memastikan hanya orang bersangkutan yang bisa
                absen.</p>
            </div>
          </div>
          <div class="col-12 col-md-3" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-graph-up icon"></i></div>
              <h4><a href="#" class="stretched-link">Data Akurat & Real-Time</a></h4>
              <p>Absensi langsung masuk ke sistem begitu dilakukan, tanpa delay. Cocok untuk supervisi jarak jauh.</p>
            </div>
          </div>
          <div class="col-12 col-md-3" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-save icon"></i></div>
              <h4><a href="#" class="stretched-link">Rekap Otomatis</a></h4>
              <p>Hemat waktu tanpa rekap manual. Semua data bisa dicetak dan disinkronkan ke sistem penggajian atau
                laporan sekolah.</p>
            </div>
          </div>
          <div class="col-12 col-md-3" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-clock icon"></i></div>
              <h4><a href="#" class="stretched-link">Efisien & Mudah Digunakan</a></h4>
              <p>Cukup buka aplikasi, selfie, dan selesai. Tidak butuh alat khusus seperti fingerprint atau kartu RFID.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>


  <footer id="footer" class="footer position-relative">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-12">
            <h4>Mulai Sekarang!</h4>
            <p>Mau aplikasi absensi digital berbasis foto selfie dan pin lokasi <br> Cocok untuk sekolah, kantor, dan
              instansi
              lainnya? Mulai sekarang gunakan {{ env('APP_NAME') }}!</p>
            <a href="https://wa.me/6285317404760?text=Halo+saya+ingin+mendaftar+aplikasi+{{ env('APP_NAME') }}+untuk+usaha/instansi+saya.+Mohon+info+selanjutnya."
              target="_blank" class="btn-get-started">
              Pesan Sekrang
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="container" id="contact">
      <div class="row text-center">
        <div class="col-lg-12 mt-5 text-center">
          <h4>Hubungi Kami</h4>
          <p class="mt-3"><strong>Telepon / WA:</strong> <a href="https://wa.me/6285317404760">+6285-3174-04760</a>
          </p>
          <p><strong>Email:</strong> <span>crm@shiftech.my.id</span></p>
        </div>
      </div>


    </div>

    <div class="copyright container mt-4 text-center">
      <p>© {{ date('Y') }} <strong class="sitename px-1"><a href="https://shiftech.my.id">Shiftech
            Indonesia</a></strong> <span>All Rights Reserved</span></p>
      <!-- <div class="credits"> -->
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you've purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
      <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div> -->
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
