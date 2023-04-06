<?php

class Structure extends Controller {  
  public function index() {
    $data = [
      'title' => 'Struktur Organisasi DKM',
      'members' => $this->model('structure_model')->getStructure(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('dkm/structure/table-data', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function new() {
    $data = [
      'title' => 'Buat Struktur Organisasi DKM',
      'members' => $this->model('members_model')->getMembers(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('dkm/structure/create', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function create() {
    try {
      $result  = $this->model('structure_model')->createStructure($_POST);

      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function edit($id) {
    $data = [
      'title' => 'Edit Struktur Organisasi DKM',
      'member' => $this->model('structure_model')->getDataById($id),
      'members' => $this->model('members_model')->getMembers(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('dkm/structure/edit', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function update() {
    try {
      $result  = $this->model('structure_model')->update($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function delete() {
    try {
      $result  = $this->model('structure_model')->delete($_POST['id']);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }
}