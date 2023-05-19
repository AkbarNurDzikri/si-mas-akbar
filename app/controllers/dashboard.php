<?php

class Dashboard extends Controller {
  public function index() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Dashboard',
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('dashboard/index', $data);
      $this->view('layouts/dashboard/footer');
    }
  }
}