<?php

class Zakat extends Controller {
  public function index() {
    $data = [
      'title' => 'Zakat',
      'zakat_fitrah_uang' => $this->model('zakat_model')->getZakatFitrahUang(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/table-data', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function fitrah() {
    $data = [
      'title' => 'Transaksi Zakat',
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/zakat-fitrah/create', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function createFitrah() {
    try {
      $result  = $this->model('zakat_model')->createFitrah($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function edit($eventId) {
    $data = [
      'title' => 'Edit Anggaran Acara',
      'budgets' => $this->model('budgeting_model')->getDataById($eventId),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('zis/zakat/edit', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function update() {
    try {
      $result  = $this->model('budgeting_model')->update($_POST);
      if($result > 0) {
        header('Location: ' . BASEURL . '/budgeting/edit/' . $_POST['event_id']);
      }
    } catch(Exception $e) {
      echo '<script>
        alert("'. $e->getMessage() .'");
        window.location.href="'. BASEURL . '/budgeting/edit/' . $_POST['event_id'] .'";
      </script>';
    }
  }

  public function delete() {
    try {
      $result  = $this->model('budgeting_model')->delete($_POST['id']);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function pdf($id) {
    $data = [
      'budgets'  => $this->model('budgeting_model')->getDataById($id),
    ];

    $this->view('zis/zakat/export-pdf', $data);
  }
}