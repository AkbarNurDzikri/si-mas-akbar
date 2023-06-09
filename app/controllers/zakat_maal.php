<?php

class Zakat_maal extends Controller {
  public function index() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Maal | Penerimaan',
        'zakat_masuk' => $this->model('zakat_maal_model')->getUangMasuk(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-maal/table-data-penerimaan', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function zakatMaalMasukAjax() {
    $columns = [
      0 => 'created_at',
      1 => 'person_name',
      2 => 'person_address',
      3 => 'qty_in',
      4 => 'remarks',
      5 => 'username',
    ];

    $queryCount = $this->model('zakat_maal_model')->getUangMasukAjaxLength();
    $dataCount = $queryCount[0];
    $totalData = $dataCount['data_rows'];
    $totalFiltered = $totalData;
    
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order'][0]['column']];
    $dir = $_POST['order'][0]['dir'];

    if(empty($_POST['search']['value'])) {
      $results = $this->model('zakat_maal_model')->getUangMasukAjax($order, $dir, $limit, $start);
    } else {
      $keyword = $_POST['search']['value'];
      $results = $this->model('zakat_maal_model')->getUangMasukAjaxSearch($order, $dir, $limit, $start, $keyword);

      $queryCount = $this->model('zakat_maal_model')->getUangMasukAjaxSearchLength($keyword);
      $dataCount = $queryCount[0];
      $totalFiltered = $dataCount['data_rows'];
    }

    $data = [];
    $no = 1;
    foreach($results as $result) {
      $nestedData['no'] = $no++ ;
      $nestedData['id'] = $result['id'];
      $nestedData['created_at'] = date('d/M/y, H:i', strtotime($result['created_at']));
      $nestedData['person_name'] = $result['person_name'];
      $nestedData['person_address'] = $result['person_address'];
      $nestedData['qty_in'] = 'Rp. ' . number_format($result['qty_in'], 2, ',', '.');
      $nestedData['remarks'] = $result['remarks'];
      $nestedData['username'] = $result['username'];
      $nestedData['action'] = '<a href="'. BASEURL . "/zakat_maal/penerimaan_edit/" . $result["id"] .'" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a> <a href="javascript:confirmDelete('. $result["id"] . ',' . "'" . $result["person_name"] . "'" .')" class="btn btn-sm btn-danger btnDelete" data-id="'. $result["id"] .'"><i class="bi bi-trash3"></i></a>';
      $data[] = $nestedData;
    }

    $json_data = [
      'draw' => intval($_POST['draw']),
      'recordsTotal' => intval($totalData),
      'recordsFiltered' => intval($totalFiltered),
      'data' => $data,
    ];

    echo json_encode($json_data);
  }

  public function catat_penerimaan() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Maal | Input Penerimaan',
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-maal/create-penerimaan', $data);
      $this->view('layouts/dashboard/footer');
    }
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Maal | Edit Penerimaan',
        'muzakki' => $this->model('zakat_maal_model')->getDataById($id),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-maal/edit-penerimaan', $data);
      $this->view('layouts/dashboard/footer');
    }
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Maal | Pengeluaran',
        'zakat_keluar' => $this->model('zakat_maal_model')->getUangKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-maal/table-data-penyaluran', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function zakatMaalKeluarAjax() {
    $columns = [
      0 => 'created_at',
      1 => 'person_name',
      2 => 'person_address',
      3 => 'qty_out',
      4 => 'remarks',
      5 => 'username',
    ];

    $queryCount = $this->model('zakat_maal_model')->getUangKeluarAjaxLength();
    $dataCount = $queryCount[0];
    $totalData = $dataCount['data_rows'];
    $totalFiltered = $totalData;
    
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order'][0]['column']];
    $dir = $_POST['order'][0]['dir'];

    if(empty($_POST['search']['value'])) {
      $results = $this->model('zakat_maal_model')->getUangKeluarAjax($order, $dir, $limit, $start);
    } else {
      $keyword = $_POST['search']['value'];
      $results = $this->model('zakat_maal_model')->getUangKeluarAjaxSearch($order, $dir, $limit, $start, $keyword);

      $queryCount = $this->model('zakat_maal_model')->getUangKeluarAjaxSearchLength($keyword);
      $dataCount = $queryCount[0];
      $totalFiltered = $dataCount['data_rows'];
    }

    $data = [];
    $no = 1;
    foreach($results as $result) {
      $nestedData['no'] = $no++ ;
      $nestedData['id'] = $result['id'];
      $nestedData['created_at'] = date('d/M/y, H:i', strtotime($result['created_at']));
      $nestedData['person_name'] = $result['person_name'];
      $nestedData['person_address'] = $result['person_address'];
      $nestedData['qty_out'] = 'Rp. ' . number_format($result['qty_out'], 2, ',', '.');
      $nestedData['remarks'] = $result['remarks'];
      $nestedData['username'] = $result['username'];
      $nestedData['action'] = '<a href="'. BASEURL . "/zakat_maal/pengeluaran_edit/" . $result["id"] .'" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a> <a href="javascript:confirmDelete('. $result["id"] . ',' . "'" . $result["person_name"] . "'" .')" class="btn btn-sm btn-danger btnDelete" data-id="'. $result["id"] .'"><i class="bi bi-trash3"></i></a>';
      $data[] = $nestedData;
    }

    $json_data = [
      'draw' => intval($_POST['draw']),
      'recordsTotal' => intval($totalData),
      'recordsFiltered' => intval($totalFiltered),
      'data' => $data,
    ];

    echo json_encode($json_data);
  }

  public function catat_pengeluaran() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Maal | Input Pengeluaran',
        'totalUangMasuk' => $this->model('zakat_maal_model')->getUangMasuk(),
        'totalUangKeluar' => $this->model('zakat_maal_model')->getUangKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-maal/create-pengeluaran', $data);
      $this->view('layouts/dashboard/footer');
    }
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'totalUangMasuk' => $this->model('zakat_maal_model')->getUangMasukBetweenDate($_POST),
        'totalUangKeluar' => $this->model('zakat_maal_model')->getUangKeluarBetweenDate($_POST),
        'start_period' => $_POST['start_date'],
        'end_period' => $_POST['end_date'],
      ];

      $this->view('zis/zakat/zakat-maal/laporan-penerimaan-pdf', $data);
    }
  }

  public function laporan_pengeluaran() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'totalUangMasuk' => $this->model('zakat_maal_model')->getUangMasukBetweenDate($_POST),
        'totalUangKeluar' => $this->model('zakat_maal_model')->getUangKeluarBetweenDate($_POST),
        'start_period' => $_POST['start_date'],
        'end_period' => $_POST['end_date'],
      ];

      $this->view('zis/zakat/zakat-maal/laporan-pengeluaran-pdf', $data);
    }
  }
}