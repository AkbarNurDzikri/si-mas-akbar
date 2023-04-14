<?php

class Zakat_fitrah extends Controller {
  public function uang() {
    $data = [
      'title' => 'Zakat Fitrah | Uang Masuk',
      'zakat_fitrah_uang_masuk' => $this->model('zakat_model')->getUangMasuk(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/table-data-penerimaan', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function catat_uang_masuk() {
    $data = [
      'title' => 'Zakat Fitrah | Input Uang Masuk',
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/create-uang-masuk', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function uang_masuk_store() {
    try {
      $result  = $this->model('zakat_model')->createZakatUang($_POST);
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
      'muzakki' => $this->model('zakat_model')->getDataById($id),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/edit-uang-masuk', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function uang_masuk_update() {
    try {
      $result  = $this->model('zakat_model')->updateZakatUang($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function uang_masuk_delete($id) {
    try {
      $result  = $this->model('zakat_model')->deleteZakatUang($id);
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
      'zakat_fitrah_uang_keluar' => $this->model('zakat_model')->getUangKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/table-data-penyaluran', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function catat_uang_keluar() {
    $data = [
      'title' => 'Zakat Fitrah | Input Uang Keluar',
      'totalUangMasuk' => $this->model('zakat_model')->getUangMasuk(),
      'totalUangKeluar' => $this->model('zakat_model')->getUangKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/create-uang-keluar', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function uang_keluar_store() {
    try {
      $result  = $this->model('zakat_model')->createZakatUang($_POST);
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
      'muzakki' => $this->model('zakat_model')->getDataById($id),
      'totalUangMasuk' => $this->model('zakat_model')->getUangMasuk(),
      'totalUangKeluar' => $this->model('zakat_model')->getUangKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/edit-uang-keluar', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function uang_keluar_update() {
    try {
      $result  = $this->model('zakat_model')->updateZakatUang($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function uang_keluar_delete($id) {
    try {
      $result  = $this->model('zakat_model')->deleteZakatUang($id);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function laporan_uang_masuk() {
    $data = [
      'totalUangMasuk' => $this->model('zakat_model')->getUangMasukBetweenDate($_POST),
      'start_period' => $_POST['start_date'],
      'end_period' => $_POST['end_date'],
    ];

    $this->view('zis/zakat/zakat-fitrah/laporan-uang-masuk-pdf', $data);
  }

  public function laporan_uang_keluar() {
    $data = [
      'totalUangKeluar' => $this->model('zakat_model')->getUangKeluarBetweenDate($_POST),
      'start_period' => $_POST['start_date'],
      'end_period' => $_POST['end_date'],
    ];

    $this->view('zis/zakat/zakat-fitrah/laporan-uang-keluar-pdf', $data);
  }
}