<?php

class Zakat_maal extends Controller {
  public function index() {
    $data = [
      'title' => 'Zakat Maal | Penerimaan',
      'zakat_masuk' => $this->model('zakat_maal_model')->getUangMasuk(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-maal/table-data-penerimaan', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function catat_penerimaan() {
    $data = [
      'title' => 'Zakat Maal | Input Penerimaan',
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-maal/create-penerimaan', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function penerimaan_store() {
    try {
      $result  = $this->model('zakat_maal_model')->createZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function penerimaan_edit($id) {
    $data = [
      'title' => 'Zakat Maal | Edit Penerimaan',
      'muzakki' => $this->model('zakat_maal_model')->getDataById($id),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-maal/edit-penerimaan', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function penerimaan_update() {
    try {
      $result  = $this->model('zakat_maal_model')->updateZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function penerimaan_delete($id) {
    try {
      $result  = $this->model('zakat_maal_model')->deleteZakat($id);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function pengeluaran() {
    $data = [
      'title' => 'Zakat Maal | Pengeluaran',
      'zakat_keluar' => $this->model('zakat_maal_model')->getUangKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-maal/table-data-penyaluran', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function catat_pengeluaran() {
    $data = [
      'title' => 'Zakat Fitrah | Input Pengeluaran',
      'totalUangMasuk' => $this->model('zakat_maal_model')->getUangMasuk(),
      'totalUangKeluar' => $this->model('zakat_maal_model')->getUangKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-maal/create-pengeluaran', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function pengeluaran_store() {
    try {
      $result  = $this->model('zakat_maal_model')->createZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function pengeluaran_edit($id) {
    $data = [
      'title' => 'Zakat Maal | Edit Pengeluaran',
      'muzakki' => $this->model('zakat_maal_model')->getDataById($id),
      'totalUangMasuk' => $this->model('zakat_maal_model')->getUangMasuk(),
      'totalUangKeluar' => $this->model('zakat_maal_model')->getUangKeluar(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-maal/edit-pengeluaran', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function pengeluaran_update() {
    try {
      $result  = $this->model('zakat_maal_model')->updateZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function pengeluaran_delete($id) {
    try {
      $result  = $this->model('zakat_maal_model')->deleteZakat($id);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function laporan_penerimaan() {
    $data = [
      'totalUangMasuk' => $this->model('zakat_maal_model')->getUangMasukBetweenDate($_POST),
      'totalUangKeluar' => $this->model('zakat_maal_model')->getUangKeluarBetweenDate($_POST),
      'start_period' => $_POST['start_date'],
      'end_period' => $_POST['end_date'],
    ];

    $this->view('zis/zakat/zakat-maal/laporan-penerimaan-pdf', $data);
  }

  public function laporan_pengeluaran() {
    $data = [
      'totalUangMasuk' => $this->model('zakat_maal_model')->getUangMasukBetweenDate($_POST),
      'totalUangKeluar' => $this->model('zakat_maal_model')->getUangKeluarBetweenDate($_POST),
      'start_period' => $_POST['start_date'],
      'end_period' => $_POST['end_date'],
    ];

    $this->view('zis/zakat/zakat-maal/laporan-pengeluaran-pdf', $data);
  }
}