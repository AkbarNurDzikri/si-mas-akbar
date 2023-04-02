<?php

class Events extends Controller {
  public function index() {
    $data = [
      'title' => 'Daftar Acara',
      'events' => $this->model('events_model')->getEvents(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('events/table-data', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function new() {
    $data = [
      'title' => 'Create Event',
      'ref_meeting' => $this->model('mom_model')->getMoms(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('events/create', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function create() {
    try {
      $result  = $this->model('events_model')->create($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function edit($id) {
    $data = [
      'title' => 'Edit Event',
      'event' => $this->model('events_model')->getDataById($id),
      'ref_meeting' => $this->model('mom_model')->getMoms(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('events/edit', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function update() {
    try {
      $result  = $this->model('events_model')->update($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function delete() {
    try {
      $result  = $this->model('events_model')->delete($_POST['id']);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  // public function pdf($id) {
  //   $data = [
  //     'notulen'  => $this->model('events_model')->getDataById($id),
  //   ];

  //   $this->view('events/export-pdf', $data);
  // }
}