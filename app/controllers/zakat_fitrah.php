<?php

class Zakat_fitrah extends Controller {
  // Zakat Uang
  public function uang() {
    $data = [
      'title' => 'Zakat Fitrah | Uang Masuk',
      'zakat_fitrah_uang_masuk' => $this->model('zakat_fitrah_model')->getUangMasuk(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/uang/table-data-penerimaan', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function catat_uang_masuk() {
    $data = [
      'title' => 'Zakat Fitrah | Input Uang Masuk',
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/uang/create-uang-masuk', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function uang_masuk_store() {
    try {
      $result  = $this->model('zakat_fitrah_model')->createZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function uang_masuk_edit($id) {
    $data = [
      'title' => 'Zakat Fitrah | Edit Uang Masuk',
      'muzakki' => $this->model('zakat_fitrah_model')->getDataById($id),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/uang/edit-uang-masuk', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function uang_masuk_update() {
    try {
      $result  = $this->model('zakat_fitrah_model')->updateZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function uang_masuk_delete($id) {
    try {
      $result  = $this->model('zakat_fitrah_model')->deleteZakat($id);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function uang_keluar() {
    $data = [
      'title' => 'Zakat Fitrah | Uang Keluar',
      'zakat_fitrah_uang_keluar' => $this->model('zakat_fitrah_model')->getUangKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/uang/table-data-penyaluran', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function catat_uang_keluar() {
    $data = [
      'title' => 'Zakat Fitrah | Input Uang Keluar',
      'totalUangMasuk' => $this->model('zakat_fitrah_model')->getUangMasuk(),
      'totalUangKeluar' => $this->model('zakat_fitrah_model')->getUangKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/uang/create-uang-keluar', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function uang_keluar_store() {
    try {
      $result  = $this->model('zakat_fitrah_model')->createZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function uang_keluar_edit($id) {
    $data = [
      'title' => 'Zakat Fitrah | Edit Uang Keluar',
      'muzakki' => $this->model('zakat_fitrah_model')->getDataById($id),
      'totalUangMasuk' => $this->model('zakat_fitrah_model')->getUangMasuk(),
      'totalUangKeluar' => $this->model('zakat_fitrah_model')->getUangKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/uang/edit-uang-keluar', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function uang_keluar_update() {
    try {
      $result  = $this->model('zakat_fitrah_model')->updateZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function uang_keluar_delete($id) {
    try {
      $result  = $this->model('zakat_fitrah_model')->deleteZakat($id);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function laporan_uang_masuk() {
    $data = [
      'totalUangMasuk' => $this->model('zakat_fitrah_model')->getUangMasukBetweenDate($_POST),
      'totalUangKeluar' => $this->model('zakat_fitrah_model')->getUangKeluarBetweenDate($_POST),
      'start_period' => $_POST['start_date'],
      'end_period' => $_POST['end_date'],
    ];

    $this->view('zis/zakat/zakat-fitrah/uang/laporan-uang-masuk-pdf', $data);
  }

  public function laporan_uang_keluar() {
    $data = [
      'totalUangMasuk' => $this->model('zakat_fitrah_model')->getUangMasukBetweenDate($_POST),
      'totalUangKeluar' => $this->model('zakat_fitrah_model')->getUangKeluarBetweenDate($_POST),
      'start_period' => $_POST['start_date'],
      'end_period' => $_POST['end_date'],
    ];

    $this->view('zis/zakat/zakat-fitrah/uang/laporan-uang-keluar-pdf', $data);
  }
  // Zakat Uang

  // Zakat Beras
  public function beras() {
    $data = [
      'title' => 'Zakat Fitrah | Beras Masuk',
      'zakat_fitrah_beras_masuk' => $this->model('zakat_fitrah_model')->getBerasMasuk(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/beras/table-data-penerimaan', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function catat_beras_masuk() {
    $data = [
      'title' => 'Zakat Fitrah | Input Beras Masuk',
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/beras/create-beras-masuk', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function beras_masuk_store() {
    try {
      $result  = $this->model('zakat_fitrah_model')->createZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function beras_masuk_edit($id) {
    $data = [
      'title' => 'Zakat Fitrah | Edit Beras Masuk',
      'muzakki' => $this->model('zakat_fitrah_model')->getDataById($id),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/beras/edit-beras-masuk', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function beras_masuk_update() {
    try {
      $result  = $this->model('zakat_fitrah_model')->updateZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function beras_masuk_delete($id) {
    try {
      $result  = $this->model('zakat_fitrah_model')->deleteZakat($id);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function beras_keluar() {
    $data = [
      'title' => 'Zakat Fitrah | Beras Keluar',
      'zakat_fitrah_beras_keluar' => $this->model('zakat_fitrah_model')->getBerasKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/beras/table-data-penyaluran', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function catat_beras_keluar() {
    $data = [
      'title' => 'Zakat Fitrah | Input Beras Keluar',
      'totalBerasMasuk' => $this->model('zakat_fitrah_model')->getBerasMasuk(),
      'totalBerasKeluar' => $this->model('zakat_fitrah_model')->getBerasKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/beras/create-beras-keluar', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function beras_keluar_store() {
    try {
      $result  = $this->model('zakat_fitrah_model')->createZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function beras_keluar_edit($id) {
    $data = [
      'title' => 'Zakat Fitrah | Edit Beras Keluar',
      'muzakki' => $this->model('zakat_fitrah_model')->getDataById($id),
      'totalBerasMasuk' => $this->model('zakat_fitrah_model')->getBerasMasuk(),
      'totalBerasKeluar' => $this->model('zakat_fitrah_model')->getBerasKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/beras/edit-beras-keluar', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function beras_keluar_update() {
    try {
      $result  = $this->model('zakat_fitrah_model')->updateZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function beras_keluar_delete($id) {
    try {
      $result  = $this->model('zakat_fitrah_model')->deleteZakat($id);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function laporan_beras_masuk() {
    $data = [
      'totalBerasMasuk' => $this->model('zakat_fitrah_model')->getBerasMasukBetweenDate($_POST),
      'totalBerasKeluar' => $this->model('zakat_fitrah_model')->getBerasKeluarBetweenDate($_POST),
      'start_period' => $_POST['start_date'],
      'end_period' => $_POST['end_date'],
    ];

    $this->view('zis/zakat/zakat-fitrah/beras/laporan-beras-masuk-pdf', $data);
  }

  public function laporan_beras_keluar() {
    $data = [
      'totalBerasMasuk' => $this->model('zakat_fitrah_model')->getBerasMasukBetweenDate($_POST),
      'totalBerasKeluar' => $this->model('zakat_fitrah_model')->getBerasKeluarBetweenDate($_POST),
      'start_period' => $_POST['start_date'],
      'end_period' => $_POST['end_date'],
    ];

    $this->view('zis/zakat/zakat-fitrah/beras/laporan-beras-keluar-pdf', $data);
  }
}