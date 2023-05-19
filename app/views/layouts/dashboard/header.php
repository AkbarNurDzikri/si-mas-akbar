<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - <?= $data['title'] ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= BASEURL . '/assets/images/icons/Foto-Masjid-Depan.ico' ?>" rel="icon">
  <!-- <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> -->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/datatables/datatables.min.css" rel="stylesheet">
  <script src="<?= BASEURL ?>/assets/dashboard/vendor/datatables/jQuery-3.6.0/jquery-3.6.0.min.js"></script>
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/sweetalert/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="<?= BASEURL ?>/assets/dashboard/vendor/sweetalert/dist/sweetalert2.min.js"></script>
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/quill/quill.bubble.css" rel="stylesheet">
  <script src="<?= BASEURL ?>/assets/dashboard/vendor/quill/quill.min.js"></script>
  <!-- <link href="<?= BASEURL ?>/assets/dashboard/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= BASEURL ?>/assets/dashboard/vendor/simple-datatables/style.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="<?= BASEURL ?>/assets/dashboard/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <!-- <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css"> -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Si-Akbar</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?= BASEURL . '/assets/images/dkm/members/' . $_SESSION['userInfo']['member_image'] ?>" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?= $_SESSION['userInfo']['member_name'] ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $_SESSION['userInfo']['member_name'] ?></h6>
              <span><?= $_SESSION['userInfo']['role_name'] ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= BASEURL . '/users/profile/' .  $_SESSION['userInfo']['member_id'] ?>">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= BASEURL . '/users/setting/' . $_SESSION['userInfo']['id'] ?>">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="<?= BASEURL . '/auth/logout' ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?= $data['title'] == 'Dashboard' ? '' : 'collapsed' ?>" href="#">
          <i class="bi bi-speedometer2"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $data['title'] == 'Daftar Notulen' || $data['title'] == 'Buat Notulen' ? '' : 'collapsed' ?>" href="<?= BASEURL . '/mom' ?>">
          <i class="bi bi-chat-right-quote"></i>
          <span>Notulen</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $data['title'] == 'Daftar Acara' || $data['title'] == 'Buat Acara' || $data['title'] == 'Edit Acara' || $data['title'] == 'Kepanitiaan' || $data['title'] == 'Buat Panitia Acara' || $data['title'] == 'Edit Panitia Acara' || $data['title'] == 'Anggaran Biaya' || $data['title'] == 'Buat Anggaran Acara' || $data['title'] == 'Edit Anggaran Acara' || $data['title'] == 'Kas Acara | Pemasukan' || $data['title'] == 'Kas Acara | Input Pemasukan' || $data['title'] == 'Kas Acara | Edit Pemasukan' ? '' : 'collapsed' ?>" data-bs-target="#agenda-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-collection-play"></i><span>Acara</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="agenda-nav" class="nav-content collapse <?= $data['title'] == 'Daftar Acara' || $data['title'] == 'Buat Acara' || $data['title'] == 'Edit Acara' || $data['title'] == 'Kepanitiaan' || $data['title'] == 'Buat Panitia Acara' || $data['title'] == 'Edit Panitia Acara' || $data['title'] == 'Anggaran Biaya' || $data['title'] == 'Buat Anggaran Acara' || $data['title'] == 'Edit Anggaran Acara' || $data['title'] == 'Kas Acara | Pemasukan' || $data['title'] == 'Kas Acara | Input Pemasukan' || $data['title'] == 'Kas Acara | Edit Pemasukan' ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= BASEURL . '/events' ?>" class="<?= $data['title'] == 'Daftar Acara' || $data['title'] == 'Buat Acara' || $data['title'] == 'Edit Acara' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Daftar Acara</span>
            </a>
          </li>
          <li>
            <a href="<?= BASEURL . '/committees' ?>" class="<?= $data['title'] == 'Kepanitiaan' || $data['title'] == 'Buat Panitia Acara' || $data['title'] == 'Edit Panitia Acara' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Kepanitiaan</span>
            </a>
          </li>
          <li>
            <a href="<?= BASEURL . '/budgeting' ?>" class="<?= $data['title'] == 'Anggaran Biaya' || $data['title'] == 'Buat Anggaran Acara' || $data['title'] == 'Edit Anggaran Acara' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Anggaran Biaya</span>
            </a>
          </li>
          <li>
            <a href="<?= BASEURL . '/event_cash' ?>" class="<?= $data['title'] == 'Kas Acara | Pemasukan' || $data['title'] == 'Kas Acara | Input Pemasukan' || $data['title'] == 'Kas Acara | Edit Pemasukan' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Kas Acara</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $data['title'] == 'Zakat Fitrah | Uang Masuk' || $data['title'] == 'Zakat Fitrah | Input Uang Masuk' || $data['title'] == 'Zakat Fitrah | Edit Uang Masuk' || $data['title'] == 'Zakat Fitrah | Uang Keluar' || $data['title'] == 'Zakat Fitrah | Input Uang Keluar' || $data['title'] == 'Zakat Fitrah | Edit Uang Keluar' || $data['title'] == 'Zakat Fitrah | Beras Masuk' || $data['title'] == 'Zakat Fitrah | Input Beras Masuk' || $data['title'] == 'Zakat Fitrah | Edit Beras Masuk' || $data['title'] == 'Zakat Fitrah | Beras Keluar' || $data['title'] == 'Zakat Fitrah | Edit Beras Keluar' || $data['title'] == 'Zakat Maal | Penerimaan' || $data['title'] == 'Zakat Maal | Input Penerimaan' || $data['title'] == 'Zakat Maal | Edit Penerimaan' || $data['title'] == 'Zakat Maal | Pengeluaran' || $data['title'] == 'Zakat Maal | Edit Pengeluaran' || $data['title'] == 'Infaq | Penerimaan' || $data['title'] == 'Infaq | Input Penerimaan' || $data['title'] == 'Infaq | Edit Penerimaan' || $data['title'] == 'Infaq | Pengeluaran' || $data['title'] == 'Infaq | Input Pengeluaran' || $data['title'] == 'Infaq | Edit Pengeluaran' || $data['title'] == 'Shadaqah' ? '' : 'collapsed' ?>" data-bs-target="#zis-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-share-fill"></i><span>Z.I.S</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="zis-nav" class="nav-content collapse <?= $data['title'] == 'Zakat Fitrah | Uang Masuk' || $data['title'] == 'Zakat Fitrah | Input Uang Masuk' || $data['title'] == 'Zakat Fitrah | Edit Uang Masuk' || $data['title'] == 'Zakat Fitrah | Uang Keluar' || $data['title'] == 'Zakat Fitrah | Input Uang Keluar' || $data['title'] == 'Zakat Fitrah | Edit Uang Keluar' || $data['title'] == 'Zakat Fitrah | Beras Masuk' || $data['title'] == 'Zakat Fitrah | Input Beras Masuk' || $data['title'] == 'Zakat Fitrah | Edit Beras Masuk' || $data['title'] == 'Zakat Fitrah | Beras Keluar' || $data['title'] == 'Zakat Fitrah | Edit Beras Keluar' || $data['title'] == 'Zakat Maal | Penerimaan' || $data['title'] == 'Zakat Maal | Input Penerimaan' || $data['title'] == 'Zakat Maal | Edit Penerimaan' || $data['title'] == 'Zakat Maal | Pengeluaran' || $data['title'] == 'Zakat Maal | Edit Pengeluaran' || $data['title'] == 'Infaq | Penerimaan' || $data['title'] == 'Infaq | Input Penerimaan' || $data['title'] == 'Infaq | Edit Penerimaan' || $data['title'] == 'Infaq | Pengeluaran' || $data['title'] == 'Infaq | Input Pengeluaran' || $data['title'] == 'Infaq | Edit Pengeluaran' || $data['title'] == 'Shadaqah' ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= BASEURL . '/zakat_fitrah/uang' ?>" class="<?= $data['title'] == 'Zakat Fitrah | Uang Masuk' || $data['title'] == 'Zakat Fitrah | Input Uang Masuk' || $data['title'] == 'Zakat Fitrah | Edit Uang Masuk' || $data['title'] == 'Zakat Fitrah | Uang Keluar' || $data['title'] == 'Zakat Fitrah | Input Uang Keluar' || $data['title'] == 'Zakat Fitrah | Edit Uang Keluar' || $data['title'] == 'Zakat Fitrah | Beras Masuk' || $data['title'] == 'Zakat Fitrah | Input Beras Masuk' || $data['title'] == 'Zakat Fitrah | Edit Beras Masuk' || $data['title'] == 'Zakat Fitrah | Beras Keluar' || $data['title'] == 'Zakat Fitrah | Edit Beras Keluar' || $data['title'] == 'Zakat Maal | Penerimaan' || $data['title'] == 'Zakat Maal | Input Penerimaan' || $data['title'] == 'Zakat Maal | Edit Penerimaan' || $data['title'] == 'Zakat Maal | Pengeluaran' || $data['title'] == 'Zakat Maal | Edit Pengeluaran' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Zakat</span>
            </a>
          </li>
          <li>
            <a href="<?= BASEURL . '/infaq' ?>" class="<?= $data['title'] == 'Infaq | Penerimaan' || $data['title'] == 'Infaq | Input Penerimaan' || $data['title'] == 'Infaq | Edit Penerimaan' || $data['title'] == 'Infaq | Pengeluaran' || $data['title'] == 'Infaq | Input Pengeluaran' || $data['title'] == 'Infaq | Edit Pengeluaran' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Infaq</span>
            </a>
          </li>
          <li>
            <a href="<?= BASEURL . '/shadaqah' ?>" class="<?= $data['title'] == 'Shadaqah' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Shadaqah</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $data['title'] == 'Struktur Organisasi DKM' || $data['title'] == 'Buat Struktur Organisasi DKM' || $data['title'] == 'Daftar Anggota DKM' || $data['title'] == 'Buat Anggota DKM' ? '' : 'collapsed' ?>" data-bs-target="#dkm-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-diagram-3"></i><span>DKM</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="dkm-nav" class="nav-content collapse <?= $data['title'] == 'Struktur Organisasi DKM' || $data['title'] == 'Buat Struktur Organisasi DKM' || $data['title'] == 'Daftar Anggota DKM' || $data['title'] == 'Buat Anggota DKM' ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= BASEURL . '/members' ?>" class="<?= $data['title'] == 'Daftar Anggota DKM' || $data['title'] == 'Buat Anggota DKM' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Daftar Anggota</span>
            </a>
          </li>
          <li>
            <a href="<?= BASEURL . '/structure' ?>" class="<?= $data['title'] == 'Struktur Organisasi DKM' || $data['title'] == 'Buat Struktur Organisasi DKM' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Struktur DKM</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link <?= $data['title'] == 'List of Users' || $data['title'] == 'Post Categories' || $data['title'] == 'List of Roles' ? '' : 'collapsed' ?>" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-database-lock"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="master-nav" class="nav-content collapse <?= $data['title'] == 'List of Users' || $data['title'] == 'Post Categories' || $data['title'] == 'List of Roles' ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?= BASEURL . '/roles' ?>" class="<?= $data['title'] == 'List of Roles' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Roles</span>
            </a>
          </li>
          <li>
            <a href="<?= BASEURL . '/users' ?>" class="<?= $data['title'] == 'List of Users' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Users</span>
            </a>
          </li>
          <li>
            <a href="<?= BASEURL . '/categories' ?>" class="<?= $data['title'] == 'Post Categories' ? 'active' : '' ?>">
              <i class="bi bi-circle"></i><span>Categories</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>

  </aside>

  <main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <!-- <li class="breadcrumb-item"><a href="#"><?= $data['title'] ?></a></li> -->
        <li class="breadcrumb-item"><?= $data['title'] ?></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">