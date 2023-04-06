<?php

class Budgeting extends Controller {
  public function index() {
    $data = [
      'title' => 'Anggaran Biaya',
      'budgets' => $this->model('budgeting_model')->getBadgets(),
      'events' => $this->model('events_model')->getEventsOpen(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('event-budgeting/table-data', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function new($eventId) {
    $data = [
      'title' => 'Buat Anggaran Acara',
      'eventId' => $eventId,
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('event-budgeting/create', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function create($eventId) {
    try {
      $result  = $this->model('budgeting_model')->create($_POST['budgets'], $eventId);
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
    $this->view('event-budgeting/edit', $data);
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

    $this->view('event-budgeting/export-pdf', $data);
  }
}