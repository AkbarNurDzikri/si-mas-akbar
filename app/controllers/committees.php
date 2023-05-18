<?php

class Committees extends Controller {
  public function index() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Kepanitiaan',
        'committees' => $this->model('committees_model')->getCommittees(),
        'events' => $this->model('events_model')->getEventsOpen(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('event-committees/table-data', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function new($eventId) {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Buat Panitia Acara',
        'eventId' => $eventId,
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('event-committees/create', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function create($eventId) {
    try {
      $result  = $this->model('committees_model')->create($_POST['panitia'], $eventId);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function edit($eventId) {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Edit Panitia Acara',
        'committee' => $this->model('committees_model')->getDataById($eventId),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('event-committees/edit', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function update() {
    try {
      $result  = $this->model('committees_model')->update($_POST);
      if($result > 0) {
        header('Location: ' . BASEURL . '/committees/edit/' . $_POST['event_id']);
      }
    } catch(Exception $e) {
      echo '<script>
        alert("'. $e->getMessage() .'");
        window.location.href="'. BASEURL . '/committees/edit/' . $_POST['event_id'] .'";
      </script>';
    }
  }

  public function delete() {
    try {
      $result  = $this->model('committees_model')->delete($_POST['id']);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function pdf($id) {
    $data = [
      'committees'  => $this->model('committees_model')->getDataById($id),
    ];

    $this->view('event-committees/export-pdf', $data);
  }
}