<?php

class Zakat_fitrah extends Controller {
  // Zakat Uang
  public function uang() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Fitrah | Uang Masuk',
        'zakat_fitrah_uang_masuk' => $this->model('zakat_fitrah_model')->getUangMasuk(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-fitrah/uang/table-data-penerimaan', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function uangMasukAjax() {
    $columns = [
      0 => 'created_at',
      1 => 'person_name',
      2 => 'person_address',
      3 => 'qty_in',
      4 => 'remarks',
      5 => 'username',
    ];

    $queryCount = $this->model('zakat_fitrah_model')->getUangMasukAjaxLength();
    $dataCount = $queryCount[0];
    $totalData = $dataCount['data_rows'];
    $totalFiltered = $totalData;
    
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order'][0]['column']];
    $dir = $_POST['order'][0]['dir'];

    if(empty($_POST['search']['value'])) {
      $results = $this->model('zakat_fitrah_model')->getUangMasukAjax($order, $dir, $limit, $start);
    } else {
      $keyword = $_POST['search']['value'];
      $results = $this->model('zakat_fitrah_model')->getUangMasukAjaxSearch($order, $dir, $limit, $start, $keyword);

      $queryCount = $this->model('zakat_fitrah_model')->getUangMasukAjaxSearchLength($keyword);
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
      $nestedData['qty_in'] = "Rp. " . number_format($result['qty_in'], 2, ',', '.');
      $nestedData['remarks'] = $result['remarks'];
      $nestedData['username'] = $result['username'];
      $nestedData['action'] = '<a href="'. BASEURL . "/zakat_fitrah/uang_masuk_edit/" . $result["id"] .'" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a> <a href="javascript:confirmDelete('. $result["id"] . ',' . "'" . $result["person_name"] . "'" .')" class="btn btn-sm btn-danger btnDelete" data-id="'. $result["id"] .'"><i class="bi bi-trash3"></i></a>';
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

  public function catat_uang_masuk() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Fitrah | Input Uang Masuk',
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-fitrah/uang/create-uang-masuk', $data);
      $this->view('layouts/dashboard/footer');
    }
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Fitrah | Edit Uang Masuk',
        'muzakki' => $this->model('zakat_fitrah_model')->getDataById($id),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-fitrah/uang/edit-uang-masuk', $data);
      $this->view('layouts/dashboard/footer');
    }
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Fitrah | Uang Keluar',
        'zakat_fitrah_uang_keluar' => $this->model('zakat_fitrah_model')->getUangKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-fitrah/uang/table-data-penyaluran', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function uangKeluarAjax() {
    $columns = [
      0 => 'created_at',
      1 => 'person_name',
      2 => 'person_status',
      3 => 'person_address',
      4 => 'qty_out',
      5 => 'remarks',
      6 => 'username',
    ];

    $queryCount = $this->model('zakat_fitrah_model')->getUangKeluarAjaxLength();
    $dataCount = $queryCount[0];
    $totalData = $dataCount['data_rows'];
    $totalFiltered = $totalData;
    
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order'][0]['column']];
    $dir = $_POST['order'][0]['dir'];

    if(empty($_POST['search']['value'])) {
      $results = $this->model('zakat_fitrah_model')->getUangKeluarAjax($order, $dir, $limit, $start);
    } else {
      $keyword = $_POST['search']['value'];
      $results = $this->model('zakat_fitrah_model')->getUangKeluarAjaxSearch($order, $dir, $limit, $start, $keyword);

      $queryCount = $this->model('zakat_fitrah_model')->getUangKeluarAjaxSearchLength($keyword);
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
      $nestedData['person_status'] = $result['person_status'];
      $nestedData['person_address'] = $result['person_address'];
      $nestedData['qty_out'] = "Rp. " . number_format($result['qty_out'], 2, ',', '.');
      $nestedData['remarks'] = $result['remarks'];
      $nestedData['username'] = $result['username'];
      $nestedData['action'] = '<a href="'. BASEURL . "/zakat_fitrah/uang_keluar_edit/" . $result["id"] .'" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a> <a href="javascript:confirmDelete('. $result["id"] . ',' . "'" . $result["person_name"] . "'" .')" class="btn btn-sm btn-danger btnDelete" data-id="'. $result["id"] .'"><i class="bi bi-trash3"></i></a>';
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

  public function catat_uang_keluar() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Fitrah | Input Uang Keluar',
        'totalUangMasuk' => $this->model('zakat_fitrah_model')->getUangMasuk(),
        'totalUangKeluar' => $this->model('zakat_fitrah_model')->getUangKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-fitrah/uang/create-uang-keluar', $data);
      $this->view('layouts/dashboard/footer');
    }
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'totalUangMasuk' => $this->model('zakat_fitrah_model')->getUangMasukBetweenDate($_POST),
        'totalUangKeluar' => $this->model('zakat_fitrah_model')->getUangKeluarBetweenDate($_POST),
        'start_period' => $_POST['start_date'],
        'end_period' => $_POST['end_date'],
      ];

      $this->view('zis/zakat/zakat-fitrah/uang/laporan-uang-masuk-pdf', $data);
    }
  }

  public function laporan_uang_keluar() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'totalUangMasuk' => $this->model('zakat_fitrah_model')->getUangMasukBetweenDate($_POST),
        'totalUangKeluar' => $this->model('zakat_fitrah_model')->getUangKeluarBetweenDate($_POST),
        'start_period' => $_POST['start_date'],
        'end_period' => $_POST['end_date'],
      ];

      $this->view('zis/zakat/zakat-fitrah/uang/laporan-uang-keluar-pdf', $data);
    }
  }
  // Zakat Uang

  // Zakat Beras
  public function beras() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Fitrah | Beras Masuk',
        'zakat_fitrah_beras_masuk' => $this->model('zakat_fitrah_model')->getBerasMasuk(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-fitrah/beras/table-data-penerimaan', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function berasMasukAjax() {
    $columns = [
      0 => 'created_at',
      1 => 'person_name',
      2 => 'person_address',
      3 => 'qty_in',
      4 => 'remarks',
      5 => 'username',
    ];

    $queryCount = $this->model('zakat_fitrah_model')->getBerasMasukAjaxLength();
    $dataCount = $queryCount[0];
    $totalData = $dataCount['data_rows'];
    $totalFiltered = $totalData;
    
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order'][0]['column']];
    $dir = $_POST['order'][0]['dir'];

    if(empty($_POST['search']['value'])) {
      $results = $this->model('zakat_fitrah_model')->getBerasMasukAjax($order, $dir, $limit, $start);
    } else {
      $keyword = $_POST['search']['value'];
      $results = $this->model('zakat_fitrah_model')->getBerasMasukAjaxSearch($order, $dir, $limit, $start, $keyword);

      $queryCount = $this->model('zakat_fitrah_model')->getBerasMasukAjaxSearchLength($keyword);
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
      $nestedData['qty_in'] = number_format($result['qty_in'], 2, ',', '.') . ' Liter';
      $nestedData['remarks'] = $result['remarks'];
      $nestedData['username'] = $result['username'];
      $nestedData['action'] = '<a href="'. BASEURL . "/zakat_fitrah/beras_masuk_edit/" . $result["id"] .'" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a> <a href="javascript:confirmDelete('. $result["id"] . ',' . "'" . $result["person_name"] . "'" .')" class="btn btn-sm btn-danger btnDelete" data-id="'. $result["id"] .'"><i class="bi bi-trash3"></i></a>';
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

  public function catat_beras_masuk() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Fitrah | Input Beras Masuk',
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-fitrah/beras/create-beras-masuk', $data);
      $this->view('layouts/dashboard/footer');
    }
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Fitrah | Edit Beras Masuk',
        'muzakki' => $this->model('zakat_fitrah_model')->getDataById($id),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-fitrah/beras/edit-beras-masuk', $data);
      $this->view('layouts/dashboard/footer');
    }
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Fitrah | Beras Keluar',
        'zakat_fitrah_beras_keluar' => $this->model('zakat_fitrah_model')->getBerasKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-fitrah/beras/table-data-penyaluran', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function berasKeluarAjax() {
    $columns = [
      0 => 'created_at',
      1 => 'person_name',
      2 => 'person_status',
      3 => 'person_address',
      4 => 'qty_out',
      5 => 'remarks',
      6 => 'username',
    ];

    $queryCount = $this->model('zakat_fitrah_model')->getBerasKeluarAjaxLength();
    $dataCount = $queryCount[0];
    $totalData = $dataCount['data_rows'];
    $totalFiltered = $totalData;
    
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order'][0]['column']];
    $dir = $_POST['order'][0]['dir'];

    if(empty($_POST['search']['value'])) {
      $results = $this->model('zakat_fitrah_model')->getBerasKeluarAjax($order, $dir, $limit, $start);
    } else {
      $keyword = $_POST['search']['value'];
      $results = $this->model('zakat_fitrah_model')->getBerasKeluarAjaxSearch($order, $dir, $limit, $start, $keyword);

      $queryCount = $this->model('zakat_fitrah_model')->getBerasKeluarAjaxSearchLength($keyword);
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
      $nestedData['person_status'] = $result['person_status'];
      $nestedData['person_address'] = $result['person_address'];
      $nestedData['qty_out'] = number_format($result['qty_out'], 2, ',', '.') . ' Liter';
      $nestedData['remarks'] = $result['remarks'];
      $nestedData['username'] = $result['username'];
      $nestedData['action'] = '<a href="'. BASEURL . "/zakat_fitrah/beras_keluar_edit/" . $result["id"] .'" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a> <a href="javascript:confirmDelete('. $result["id"] . ',' . "'" . $result["person_name"] . "'" .')" class="btn btn-sm btn-danger btnDelete" data-id="'. $result["id"] .'"><i class="bi bi-trash3"></i></a>';
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

  public function catat_beras_keluar() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Zakat Fitrah | Input Beras Keluar',
        'totalBerasMasuk' => $this->model('zakat_fitrah_model')->getBerasMasuk(),
        'totalBerasKeluar' => $this->model('zakat_fitrah_model')->getBerasKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/zakat/zakat-fitrah/beras/create-beras-keluar', $data);
      $this->view('layouts/dashboard/footer');
    }
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'totalBerasMasuk' => $this->model('zakat_fitrah_model')->getBerasMasukBetweenDate($_POST),
        'totalBerasKeluar' => $this->model('zakat_fitrah_model')->getBerasKeluarBetweenDate($_POST),
        'start_period' => $_POST['start_date'],
        'end_period' => $_POST['end_date'],
      ];

      $this->view('zis/zakat/zakat-fitrah/beras/laporan-beras-masuk-pdf', $data);
    }
  }

  public function laporan_beras_keluar() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'totalBerasMasuk' => $this->model('zakat_fitrah_model')->getBerasMasukBetweenDate($_POST),
        'totalBerasKeluar' => $this->model('zakat_fitrah_model')->getBerasKeluarBetweenDate($_POST),
        'start_period' => $_POST['start_date'],
        'end_period' => $_POST['end_date'],
      ];

      $this->view('zis/zakat/zakat-fitrah/beras/laporan-beras-keluar-pdf', $data);
    }
  }
}