<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Klinik Amikom</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('landingpage') }}/img/logo_amikom.png" rel="icon">
    <link href="{{ asset('landingpage') }}/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('landingpage') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('landingpage') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('landingpage') }}/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('landingpage') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="{{ asset('landingpage') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('landingpage') }}/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Strategy
  * Template URL: https://bootstrapmade.com/strategy-bootstrap-agency-template/
  * Updated: Jun 06 2025 with Bootstrap v5.3.6
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div
            class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="{{ asset('landingpage') }}/img/logo.webp" alt=""> -->
                <h1 class="sitename" style="color: #ffffff;">Klinik Amikom</h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Beranda</a></li>
                    <li><a href="#about">Tentang Klinik</a></li>
                    <li><a href="#team">Tim Medis</a></li>
                    <li><a href="#contact">Kontak</a></li>
                    <li class="dropdown"><a href="#"><span>Lainnya</span> <i
                                class="bi bi-chevron-down toggle-dropdown"></i></a>
                        <ul>
                            <li><a href="#">Layanan Klinik</a></li>
                            <li><a href="#info-poli">Informasi Poli Umum & Gigi</a></li>
                            <li class="dropdown">
                                <a href="#"><span>Jadwal</span>
                                    <i class="bi bi-chevron-down toggle-dropdown"></i>
                                </a>
                                <ul>
                                    <li><a href="#jadwal-klinik">Jadwal Klinik</a></li>
                                    <li><a href="#jadwal-dokter">Jadwal Dokter</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <div class="btn-group">
                <a class="btn-getstarted" href="{{ route('profile.basic-details.form') }}">Form Pendaftaran Pasien</a>
                <a class="btn-getstarted" href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </header>
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 content-col" data-aos="fade-up">
                        <div class="content">
                            <div class="main-heading">
                                <h1>KLINIK <br>AMIKOM</h1>
                            </div>

                            <div class="divider"></div>

                            <div class="description">
                                <p style="text-align: justify;">
                                    Klinik Amikom adalah fasilitas kesehatan gratis yang disediakan oleh Universitas
                                    Amikom Yogyakarta.
                                    Klinik ini memiliki dua layanan utama, yaitu Poli Umum dan Poli Gigi. Berlokasi di
                                    Gedung 3 Lantai 1,
                                    klinik ini diperuntukkan bagi seluruh mahasiswa, dosen, dan karyawan Amikom tanpa
                                    dipungut biaya.
                                </p>
                            </div>
                            <div class="cta-button">
                                <a href="#services" class="btn">
                                    <span>INFORMASI SELENGKAPNYA</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5" data-aos="zoom-out">
                        <div class="visual-content">
                            <div class="fluid-shape">
                                <img src="{{ asset('landingpage') }}/img/abstract/logo_UAYO.png"
                                    alt="Abstract Fluid Shape" class="fluid-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">
            <!-- Section Title -->
            <div id="services" class="container section-title" data-aos="fade-up">
                <h2>Tentang</h2>
                <div><span>Klinik Amikom</span></div>
            </div>

            <div class="container">

                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
                        <div class="about-image position-relative">
                            <img src="{{ asset('landingpage') }}/img/about/gedung.png"
                                class="img-fluid rounded-4 shadow-sm" alt="About Image">
                        </div>
                    </div>

                    <div class="col-lg-6 mt-4 mt-lg-0" data-aos="fade-left" data-aos-delay="300">
                        <div class="about-content">
                            <h2 style="text-align: justify;">Meningkatkan Kesejahteraan Sivitas Akademika Melalui
                                Layanan Kesehatan</h2>
                            <p class="lead" style="text-align: justify;">Klinik Amikom hadir sebagai komitmen
                                Universitas Amikom Yogyakarta dalam
                                menyediakan
                                fasilitas kesehatan gratis bagi seluruh civitas kampus.</p>
                            <p style="text-align: justify;">Dengan layanan Poli Umum dan Poli Gigi, klinik ini
                                mendukung kenyamanan, produktivitas,
                                dan kualitas
                                hidup mahasiswa, dosen, serta karyawan di lingkungan kampus.</p>

                            <div class="row g-4 mt-3">
                                <div class="col-md-6" data-aos="zoom-in" data-aos-delay="400">
                                    <div class="feature-item">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <h5>Tim Medis Profesional</h5>
                                        <p style="text-align: justify;">Tenaga kesehatan berpengalaman siap memberikan
                                            pelayanan yang ramah, cepat,
                                            dan tepat untuk
                                            seluruh civitas akademika.</p>
                                    </div>
                                </div>
                                <div class="col-md-6" data-aos="zoom-in" data-aos-delay="450">
                                    <div class="feature-item">
                                        <i class="bi bi-lightbulb-fill"></i>
                                        <h5>Pelayanan Proaktif dan Responsif</h5>
                                        <p style="text-align: justify;">Klinik Amikom mengutamakan kenyamanan pasien
                                            dengan pendekatan pelayanan yang
                                            sigap, modern, dan
                                            berorientasi pada kebutuhan.</p>
                                    </div>
                                </div>
                            </div>
                            <a href="#layanan" class="btn btn-primary mt-4">Lihat Layanan Klinik</a>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Steps Section -->
        <section id="steps" class="steps section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Langkah - langkah</h2>
                <div><span>Bagaimana</span> <span class="description-title">Klinik Amikom Bekerja</span></div>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="steps-wrapper">

                    <div class="step-item" data-aos="fade-right" data-aos-delay="200">
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="bi bi-lightbulb"></i>
                            </div>
                            <div class="step-info">
                                <span class="step-number" style="color: #e3a127">Langkah 01</span>
                                <h3>Akses Website Klinik</h3>
                                <p>Buka website resmi Klinik Amikom melalui perangkat Anda untuk memulai proses
                                    pendaftaran secara online.</p>
                            </div>
                        </div>
                    </div><!-- End Step Item -->

                    <div class="step-item" data-aos="fade-left" data-aos-delay="300">
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="bi bi-gear"></i>
                            </div>
                            <div class="step-info">
                                <span class="step-number" style="color: #e3a127">Langkah 02</span>
                                <h3>Cek Jadwal & Isi Form</h3>
                                <p>Lihat jadwal layanan klinik yang tersedia, lalu isi formulir pendaftaran yang telah
                                    disediakan dengan data yang lengkap dan benar.</p>
                            </div>
                        </div>
                    </div><!-- End Step Item -->

                    <div class="step-item" data-aos="fade-right" data-aos-delay="400">
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                            <div class="step-info">
                                <span class="step-number" style="color: #e3a127">Langkah 03</span>
                                <h3>Tunggu Konfirmasi</h3>
                                <p>Setelah pendaftaran, Anda akan menerima konfirmasi dan nomor antrian dari pihak
                                    klinik melalui email atau WhatsApp.</p>
                            </div>
                        </div>
                    </div><!-- End Step Item -->

                    <div class="step-item" data-aos="fade-left" data-aos-delay="500">
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                            <div class="step-info">
                                <span class="step-number" style="color: #e3a127">Langkah 04</span>
                                <h3>Datang ke Klinik</h3>
                                <p>Datang langsung ke Klinik Amikom sesuai jadwal dan nomor antrian yang telah Anda
                                    terima untuk mendapatkan layanan kesehatan.</p>
                            </div>
                        </div>
                    </div><!-- End Step Item -->
                </div>
            </div>
        </section><!-- /Steps Section -->

        <section id="info-poli" class="info-poli">
            <h2 id="layanan" class="judul-jadwal">Informasi Layanan Poli</h2>
            <div class="poli-wrapper">
                <!-- Poli Umum -->
                <div class="poli-box">
                    <h3 style="color: #e3a127">Poli Umum</h3>
                    <p style="text-align: justify;">
                        Poli Umum Klinik Amikom melayani pemeriksaan kesehatan umum seperti demam, flu, batuk, tekanan
                        darah, dan konsultasi kesehatan dasar lainnya.
                        Layanan ini cocok bagi pasien yang membutuhkan diagnosis awal atau penanganan penyakit ringan.
                    </p>
                </div>

                <!-- Poli Gigi -->
                <div class="poli-box">
                    <h3 style="color: #e3a127">Poli Gigi</h3>
                    <p style="text-align: justify;">
                        Poli Gigi menyediakan layanan perawatan kesehatan gigi dan mulut seperti pemeriksaan gigi,
                        pembersihan karang gigi, penambalan, pencabutan, dan konsultasi perawatan gigi lainnya.
                        Ditangani oleh dokter gigi profesional dengan peralatan yang higienis.
                    </p>
                </div>
            </div>
        </section>

        <section id="jadwal-dokter" class="jadwal-dokter">
            <h2 class="judul-jadwal">Jadwal Dokter Klinik Amikom</h2>
            <table class="tabel-jadwal">
                <thead class="thead-white">
                    <tr>
                        <th>Nama Dokter</th>
                        <th>Poli</th>
                        <th>Hari Praktik</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Dr. A</td>
                        <td>Poli Umum</td>
                        <td>Senin & Rabu</td>
                        <td>08:00 - 12:00</td>
                    </tr>
                    <tr>
                        <td>Dr. B</td>
                        <td>Poli Umum</td>
                        <td>Selasa & Kamis</td>
                        <td>10:00 - 14:00</td>
                    </tr>
                    <tr>
                        <td>Dr. C</td>
                        <td>Poli Gigi</td>
                        <td>Senin & Jumat</td>
                        <td>09:00 - 13:00</td>
                    </tr>
                    <tr>
                        <td>Dr. D</td>
                        <td>Poli Gigi</td>
                        <td>Rabu & Kamis</td>
                        <td>13:00 - 17:00</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section id="jadwal-klinik" class="jadwal-klinik">
            <h2 class="judul-jadwal">Jadwal Operasional Klinik Amikom</h2>
            <table class="tabel-jadwal">
                <thead class="thead-white">
                    <tr>
                        <th>Hari</th>
                        <th>Jam Buka</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Senin - Jum'at</td>
                        <td>09.00 - 15:00</td>
                    </tr>
                    <tr>
                        <td>Sabtu & Minggu</td>
                        <td>Tutup</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="testimonials section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Testimoni</h2>
                <div><span>Testimoni</span> <span class="description-title">Klinik Amikom</span></div>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="testimonials-slider swiper init-swiper">
                    <script type="application/json" class="swiper-config">
            {
              "slidesPerView": 1,
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "navigation": {
                "nextEl": ".swiper-button-next",
                "prevEl": ".swiper-button-prev"
              }
            }
          </script>

                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h2>Pelayanan Ramah dan Cepat</h2>
                                        <p style="text-align: justify;">
                                            Saya datang ke Klinik Amikom saat sedang merasa tidak enak badan di tengah
                                            padatnya jadwal kuliah. Ternyata proses pendaftarannya sangat cepat, dan
                                            dokter serta perawatnya ramah sekali. Saya merasa sangat terbantu.
                                        </p>
                                        <p style="text-align: justify;">
                                            Obat yang diberikan pun efektif, dan penjelasan dari dokter sangat mudah
                                            dipahami. Klinik ini sangat cocok untuk mahasiswa seperti saya yang butuh
                                            pelayanan cepat dan nyaman.
                                        </p>
                                        <div class="profile d-flex align-items-center">
                                            <img src="{{ asset('landingpage') }}/img/person/person-m-7.webp"
                                                class="profile-img" alt="">
                                            <div class="profile-info">
                                                <h3>Rizky Santosa</h3>
                                                <span style="color: #e3a127">Mahasiswa</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-none d-lg-block">
                                        <div class="featured-img-wrapper">
                                            <img src="{{ asset('landingpage') }}/img/person/person-m-7.webp"
                                                class="featured-img" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Testimonial Item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h2>Tenaga Medis Profesional dan Informatif</h2>
                                        <p style="text-align: justify;">
                                            Sebagai dosen, saya menghargai kejelasan informasi dalam proses pengobatan.
                                            Saat berobat ke Klinik Amikom, saya merasa dilayani dengan sangat
                                            profesional. Diagnosa disampaikan dengan rinci, dan saya diberi beberapa
                                            opsi pengobatan yang sesuai.
                                        </p>
                                        <p style="text-align: justify;">
                                            Fasilitas kliniknya bersih dan tertata dengan baik. Ini menjadi contoh
                                            pelayanan kesehatan kampus yang ideal.
                                        </p>
                                        <div class="profile d-flex align-items-center">
                                            <img src="{{ asset('landingpage') }}/img/person/person-f-8.webp"
                                                class="profile-img" alt="">
                                            <div class="profile-info">
                                                <h3>Dr. Alya Nurhaliza</h3>
                                                <span style="color: #e3a127">Dosen</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-none d-lg-block">
                                        <div class="featured-img-wrapper">
                                            <img src="{{ asset('landingpage') }}/img/person/person-f-8.webp"
                                                class="featured-img" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Testimonial Item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h2>
                                            Solusi Kesehatan yang Praktis dan Efisien
                                        </h2>
                                        <p style="text-align: justify;">
                                            Saya bekerja di lingkungan kampus dan sering tidak punya banyak waktu untuk
                                            ke luar kampus hanya untuk periksa. Untungnya, Klinik Amikom sangat
                                            membantu. Pelayanannya efisien, antrian tidak lama, dan obat bisa langsung
                                            diambil setelah konsultasi.
                                        </p>
                                        <p style="text-align: justify;">
                                            Sangat direkomendasikan untuk rekan-rekan karyawan yang ingin pemeriksaan
                                            rutin tanpa mengganggu jam kerja.
                                        </p>
                                        <div class="profile d-flex align-items-center">
                                            <img src="{{ asset('landingpage') }}/img/person/person-m-9.webp"
                                                class="profile-img" alt="">
                                            <div class="profile-info">
                                                <h3>Andi Prasetyo</h3>
                                                <span style="color: #e3a127">Karyawan</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 d-none d-lg-block">
                                        <div class="featured-img-wrapper">
                                            <img src="{{ asset('landingpage') }}/img/person/person-m-9.webp"
                                                class="featured-img" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Testimonial Item -->
                    </div>
                    <div class="swiper-navigation w-100 d-flex align-items-center justify-content-center">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </section><!-- /Testimonials Section -->

        <!-- Team Section -->
        <section id="team" class="team section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Tim</h2>
                <div><span>Tim</span> <span class="description-title">Medis</span></div>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="team-member d-flex">
                            <div class="member-img">
                                <img src="{{ asset('landingpage') }}/img/person/person-m-7.webp" class="img-fluid"
                                    alt="" loading="lazy">
                            </div>
                            <div class="member-info flex-grow-1">
                                <h4 style="color: #e3a127">dr. Andini Pratama</h4>
                                <span>Dokter Poli Umum</span>
                                <p style="text-align: justify;">Memberikan pelayanan pemeriksaan umum, diagnosa ringan,
                                    serta konsultasi kesehatan
                                    bagi mahasiswa dan staf Amikom.
                                </p>
                                <div class="social">
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                    <a href=""><i class="bi bi-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="team-member d-flex">
                            <div class="member-img">
                                <img src="{{ asset('landingpage') }}/img/person/person-f-8.webp" class="img-fluid"
                                    alt="" loading="lazy">
                            </div>
                            <div class="member-info flex-grow-1">
                                <h4 style="color: #e3a127">drg. Sarah Jhonson</h4>
                                <span>Dokter Poli Gigi</span>
                                <p style="text-align: justify;">Menangani pemeriksaan dan tindakan ringan terkait
                                    kesehatan gigi dan mulut, seperti
                                    pembersihan karang gigi dan penanganan nyeri gigi.</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                    <a href=""><i class="bi bi-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="team-member d-flex">
                            <div class="member-img">
                                <img src="{{ asset('landingpage') }}/img/person/person-m-6.webp" class="img-fluid"
                                    alt="" loading="lazy">
                            </div>
                            <div class="member-info flex-grow-1">
                                <h4 style="color: #e3a127">William Anderson, S.Farm., Apt</h4>
                                <span>Apoteker Klinik</span>
                                <p style="text-align: justify;">Mengelola penyediaan obat, meracik resep dokter, dan
                                    memberikan informasi penggunaan
                                    obat kepada pasien dengan aman dan tepat.</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                    <a href=""><i class="bi bi-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="team-member d-flex">
                            <div class="member-img">
                                <img src="{{ asset('landingpage') }}/img/person/person-f-4.webp" class="img-fluid"
                                    alt="" loading="lazy">
                            </div>
                            <div class="member-info flex-grow-1">
                                <h4 style="color: #e3a127">Amanda Jepson</h4>
                                <span>Administrator Klinik</span>
                                <p style="text-align: justify;">Mengatur jadwal pelayanan, mencatat data pasien, dan
                                    memastikan proses administratif
                                    berjalan lancar dan efisien.</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                    <a href=""><i class="bi bi-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="team-member d-flex">
                            <div class="member-img">
                                <img src="{{ asset('landingpage') }}/img/person/person-m-12.webp" class="img-fluid"
                                    alt="" loading="lazy">
                            </div>
                            <div class="member-info flex-grow-1">
                                <h4 style="color: #e3a127">dr. Brian Doe</h4>
                                <span>Kepala Klinik Amikom</span>
                                <p style="text-align: justify;">Bertanggung jawab atas pengawasan dan manajemen
                                    keseluruhan layanan klinik,
                                    memastikan kualitas dan kenyamanan pelayanan kesehatan.</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-twitter-x"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                    <a href=""><i class="bi bi-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Team Member -->
                </div>
            </div>
        </section><!-- /Team Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak</h2>
                <div><span>Kontak</span> <span class="description-title">Kami</span></div>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <!-- Contact Info Boxes -->
                <div class="row gy-4 mb-5">
                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="contact-info-box">
                            <div class="icon-box">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="info-content">
                                <h4>Alamat Kami</h4>
                                <p>Universitas Amikom Yogyakarta</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="contact-info-box">
                            <div class="icon-box">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="info-content">
                                <h4>Email</h4>
                                <p>klinikamikom@example.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="contact-info-box">
                            <div class="icon-box">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div class="info-content">
                                <h4>Jam Operasional</h4>
                                <p>Senin - Jum'at: 09.00 - 15.00</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3" data-aos="fade-up" data-aos-delay="400">
                        <div class="contact-info-box">
                            <div class="icon-box">
                                <i class="bi bi-headset"></i>
                            </div>
                            <div class="info-content">
                                <h4>Dokter Praktek</h4>
                                <p>Senin - Jum'at: 10.00 - 15.00</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Google Maps (Full Width) -->
            <div class="map-section" data-aos="fade-up" data-aos-delay="200">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3165.7139736601816!2d110.4090461!3d-7.7599048999999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a599bd3bdc4ef%3A0x6f1714b0c4544586!2sUniversity%20of%20Amikom%20Yogyakarta!5e1!3m2!1sen!2sid!4v1751693469312!5m2!1sen!2sid"
                    width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

        </section><!-- /Contact Section -->

    </main>

    <footer id="footer" class="footer">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">Klinik Amikom</span>
                    </a>
                    <p>Klinik Amikom Yogyakarta menyediakan layanan kesehatan seperti Poli Umum dan Poli Gigi untuk
                        seluruh
                        sivitas akademika dan masyarakat umum dengan pelayanan profesional dan ramah.</p>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    <h4>Link Terkait</h4>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Tentang Klinik</a></li>
                        <li><a href="#">Layanan Poli</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    <h4>Layanan Klinik</h4>
                    <ul>
                        <li><a href="#">Poli Umum</a></li>
                        <li><a href="#">Poli Gigi</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Kontak Kami</h4>
                    <p>Jl. Ring Road Utara, Condong Catur, Sleman, Yogyakarta</p>
                    <p class="mt-4"><strong>No.Telp:</strong> <span>+62 87890876543</span></p>
                    <p><strong>Email:</strong> <span>klinikamikom@example.com</span></p>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Klinik Amikom</strong> <span>All Rights
                    Reserved</span></p>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('landingpage') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('landingpage') }}/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('landingpage') }}/vendor/aos/aos.js"></script>
    <script src="{{ asset('landingpage') }}/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('landingpage') }}/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('landingpage') }}/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{ asset('landingpage') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('landingpage') }}/js/main.js"></script>

</body>

</html>
