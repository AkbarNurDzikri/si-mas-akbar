<?php

class Infaq extends Controller {
  public function index() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Infaq | Penerimaan',
        'infaq_masuk' => $this->model('infaq_model')->getInfaqMasuk(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/infaq/table-data-penerimaan', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function infaqMasukAjax() {
    $columns = [
      0 => 'created_at',
      1 => 'person_name',
      2 => 'person_address',
      3 => 'qty_in',
      4 => 'remarks',
      5 => 'username',
    ];

    $queryCount = $this->model('infaq_model')->getInfaqMasukAjaxLength();
    $dataCount = $queryCount[0];
    $totalData = $dataCount['data_rows'];
    $totalFiltered = $totalData;
    
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order'][0]['column']];
    $dir = $_POST['order'][0]['dir'];

    if(empty($_POST['search']['value'])) {
      $results = $this->model('infaq_model')->getInfaqMasukAjax($order, $dir, $limit, $start);
    } else {
      $keyword = $_POST['search']['value'];
      $results = $this->model('infaq_model')->getInfaqMasukAjaxSearch($order, $dir, $limit, $start, $keyword);

      $queryCount = $this->model('infaq_model')->getInfaqMasukAjaxSearchLength($keyword);
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
      $nestedData['action'] = '<a href="'. BASEURL . "/infaq/penerimaan_edit/" . $result["id"] .'" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a> <a href="javascript:confirmDelete('. $result["id"] . ',' . "'" . $result["person_name"] . "'" .')" class="btn btn-sm btn-danger btnDelete" data-id="'. $result["id"] .'"><i class="bi bi-trash3"></i></a>';
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
        'title' => 'Infaq | Input Penerimaan',
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/infaq/create-penerimaan', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function penerimaan_store() {
    try {
      $result  = $this->model('infaq_model')->createInfaq($_POST);
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
        'title' => 'Infaq | Edit Penerimaan',
        'muslim' => $this->model('infaq_model')->getDataById($id),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/infaq/edit-penerimaan', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function penerimaan_update() {
    try {
      $result  = $this->model('infaq_model')->updateInfaq($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function penerimaan_delete($id) {
    try {
      $result  = $this->model('infaq_model')->deleteInfaq($id);
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
        'title' => 'Infaq | Pengeluaran',
        'infaq_keluar' => $this->model('infaq_model')->getInfaqKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/infaq/table-data-penyaluran', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function infaqKeluarAjax() {
    $columns = [
      0 => 'created_at',
      1 => 'person_name',
      2 => 'person_address',
      3 => 'qty_out',
      4 => 'remarks',
      5 => 'username',
    ];

    $queryCount = $this->model('infaq_model')->getInfaqKeluarAjaxLength();
    $dataCount = $queryCount[0];
    $totalData = $dataCount['data_rows'];
    $totalFiltered = $totalData;
    
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order'][0]['column']];
    $dir = $_POST['order'][0]['dir'];

    if(empty($_POST['search']['value'])) {
      $results = $this->model('infaq_model')->getInfaqKeluarAjax($order, $dir, $limit, $start);
    } else {
      $keyword = $_POST['search']['value'];
      $results = $this->model('infaq_model')->getInfaqKeluarAjaxSearch($order, $dir, $limit, $start, $keyword);

      $queryCount = $this->model('infaq_model')->getInfaqKeluarAjaxSearchLength($keyword);
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
      $nestedData['action'] = '<a href="'. BASEURL . "/infaq/pengeluaran_edit/" . $result["id"] .'" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a> <a href="javascript:confirmDelete('. $result["id"] . ',' . "'" . $result["person_name"] . "'" .')" class="btn btn-sm btn-danger btnDelete" data-id="'. $result["id"] .'"><i class="bi bi-trash3"></i></a>';
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
        'title' => 'Infaq | Input Pengeluaran',
        'totalUangMasuk' => $this->model('infaq_model')->getInfaqMasuk(),
        'totalUangKeluar' => $this->model('infaq_model')->getInfaqKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/infaq/create-pengeluaran', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function pengeluaran_store() {
    try {
      $result  = $this->model('infaq_model')->createInfaq($_POST);
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
        'title' => 'Infaq | Edit Pengeluaran',
        'muslim' => $this->model('infaq_model')->getDataById($id),
        'totalUangMasuk' => $this->model('infaq_model')->getInfaqMasuk(),
        'totalUangKeluar' => $this->model('infaq_model')->getInfaqKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('zis/infaq/edit-pengeluaran', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function pengeluaran_update() {
    try {
      $result  = $this->model('infaq_model')->updateInfaq($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function pengeluaran_delete($id) {
    try {
      $result  = $this->model('infaq_model')->deleteInfaq($id);
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
        'totalUangMasuk' => $this->model('infaq_model')->getInfaqMasukBetweenDate($_POST),
        'totalUangKeluar' => $this->model('infaq_model')->getInfaqKeluarBetweenDate($_POST),
        'start_period' => $_POST['start_date'],
        'end_period' => $_POST['end_date'],
      ];

      $this->view('zis/infaq/laporan-penerimaan-pdf', $data);
    }
  }

  public function laporan_pengeluaran() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'totalUangMasuk' => $this->model('infaq_model')->getInfaqMasukBetweenDate($_POST),
        'totalUangKeluar' => $this->model('infaq_model')->getInfaqKeluarBetweenDate($_POST),
        'start_period' => $_POST['start_date'],
        'end_period' => $_POST['end_date'],
      ];

      $this->view('zis/infaq/laporan-pengeluaran-pdf', $data);
    }
  }
}