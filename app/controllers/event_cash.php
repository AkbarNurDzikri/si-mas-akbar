<?php

class Event_cash extends Controller {
  public function index() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Kas Acara | Pemasukan',
        'kas_masuk' => $this->model('event_cash_model')->getUangMasuk(),
        'ref_events' => $this->model('events_model')->getEventsOpen(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('event-cash/table-data-penerimaan', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function kasMasukAjax() {
    $columns = [
      0 => 'created_at',
      1 => 'event_name',
      2 => 'remarks',
      3 => 'qty_in',
      4 => 'username',
    ];

    $queryCount = $this->model('event_cash_model')->getUangMasukAjaxLength();
    $dataCount = $queryCount[0];
    $totalData = $dataCount['data_rows'];
    $totalFiltered = $totalData;
    
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order'][0]['column']];
    $dir = $_POST['order'][0]['dir'];

    if(empty($_POST['search']['value'])) {
      $results = $this->model('event_cash_model')->getUangMasukAjax($order, $dir, $limit, $start);
    } else {
      $keyword = $_POST['search']['value'];
      $results = $this->model('event_cash_model')->getUangMasukAjaxSearch($order, $dir, $limit, $start, $keyword);

      $queryCount = $this->model('event_cash_model')->getUangMasukAjaxSearchLength($keyword);
      $dataCount = $queryCount[0];
      $totalFiltered = $dataCount['data_rows'];
    }

    $data = [];
    $no = 1;
    foreach($results as $result) {
      $nestedData['no'] = $no++ ;
      $nestedData['id'] = $result['id'];
      $nestedData['created_at'] = date('d/M/y, H:i', strtotime($result['created_at']));
      $nestedData['event_name'] = $result['event_name'];
      $nestedData['remarks'] = $result['remarks'];
      $nestedData['qty_in'] = 'Rp. ' . number_format($result['qty_in'], 2, ',', '.');
      $nestedData['username'] = $result['username'];
      $nestedData['action'] = '<a href="'. BASEURL . "/event_cash/pemasukan_edit/" . $result["id"] .'" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a> <a href="javascript:confirmDelete('. $result["id"] .')" class="btn btn-sm btn-danger btnDelete" data-id="'. $result["id"] .'"><i class="bi bi-trash3"></i></a>';
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

  public function catat_pemasukan() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Kas Acara | Input Pemasukan',
        'ref_events' => $this->model('events_model')->getEventsOpen(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('event-cash/create-pemasukan', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function pemasukan_store() {
    try {
      $result  = $this->model('event_cash_model')->createKasAcara($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function pemasukan_edit($id) {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Kas Acara | Edit Pemasukan',
        'kas_masuk' => $this->model('event_cash_model')->getDataById($id),
        'ref_events' => $this->model('events_model')->getEventsOpen(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('event-cash/edit-pemasukan', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function pemasukan_update() {
    try {
      $result  = $this->model('event_cash_model')->updateKasAcara($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function pemasukan_delete($id) {
    try {
      $result  = $this->model('event_cash_model')->deleteKasAcara($id);
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
        'title' => 'Kas Acara | Pengeluaran',
        'zakat_keluar' => $this->model('event_cash_model')->getUangKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('event-cash/table-data-penyaluran', $data);
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

    $queryCount = $this->model('event_cash_model')->getUangKeluarAjaxLength();
    $dataCount = $queryCount[0];
    $totalData = $dataCount['data_rows'];
    $totalFiltered = $totalData;
    
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $order = $columns[$_POST['order'][0]['column']];
    $dir = $_POST['order'][0]['dir'];

    if(empty($_POST['search']['value'])) {
      $results = $this->model('event_cash_model')->getUangKeluarAjax($order, $dir, $limit, $start);
    } else {
      $keyword = $_POST['search']['value'];
      $results = $this->model('event_cash_model')->getUangKeluarAjaxSearch($order, $dir, $limit, $start, $keyword);

      $queryCount = $this->model('event_cash_model')->getUangKeluarAjaxSearchLength($keyword);
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
        'title' => 'Kas Acara | Input Pengeluaran',
        'totalUangMasuk' => $this->model('event_cash_model')->getUangMasuk(),
        'totalUangKeluar' => $this->model('event_cash_model')->getUangKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('event-cash/create-pengeluaran', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function pengeluaran_store() {
    try {
      $result  = $this->model('event_cash_model')->createZakat($_POST);
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
        'title' => 'Kas Acara | Edit Pengeluaran',
        'muzakki' => $this->model('event_cash_model')->getDataById($id),
        'totalUangMasuk' => $this->model('event_cash_model')->getUangMasuk(),
        'totalUangKeluar' => $this->model('event_cash_model')->getUangKeluar(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('event-cash/edit-pengeluaran', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function pengeluaran_update() {
    try {
      $result  = $this->model('event_cash_model')->updateZakat($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function pengeluaran_delete($id) {
    try {
      $result  = $this->model('event_cash_model')->deleteZakat($id);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function laporan_pemasukan($refEvent) {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'totalUangMasuk' => $this->model('event_cash_model')->getUangMasukBetweenDate($_POST, $refEvent),
        'totalUangKeluar' => $this->model('event_cash_model')->getUangKeluarBetweenDate($_POST, $refEvent),
        'start_period' => $_POST['start_date'],
        'end_period' => $_POST['end_date'],
      ];

      $this->view('event-cash/laporan-penerimaan-pdf', $data);
    }
  }

  public function laporan_pengeluaran() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'totalUangMasuk' => $this->model('event_cash_model')->getUangMasukBetweenDate($_POST),
        'totalUangKeluar' => $this->model('event_cash_model')->getUangKeluarBetweenDate($_POST),
        'start_period' => $_POST['start_date'],
        'end_period' => $_POST['end_date'],
      ];

      $this->view('event-cash/laporan-pengeluaran-pdf', $data);
    }
  }
}