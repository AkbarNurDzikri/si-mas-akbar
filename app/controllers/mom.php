<?php

class Mom extends Controller {
  public function index() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Daftar Notulen',
        'moms' => $this->model('mom_model')->getMoms(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('minutes-of-meeting/table-data', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function new() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Buat Notulen',
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('minutes-of-meeting/create');
      $this->view('layouts/dashboard/footer');
    }
  }

  public function create() {
    try {
      $result  = $this->model('mom_model')->create($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function edit($id) {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Edit Notulen',
        'mom' => $this->model('mom_model')->getDataById($id),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('minutes-of-meeting/edit', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function update() {
    try {
      $result  = $this->model('mom_model')->update($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function delete() {
    try {
      $result  = $this->model('mom_model')->delete($_POST['id']);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function pdf($id) {
    $data = [
      'notulen'  => $this->model('mom_model')->getDataById($id),
    ];

    $this->view('minutes-of-meeting/export-pdf', $data);
  }
}