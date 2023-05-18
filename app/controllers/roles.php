<?php

class Roles extends Controller {  
  public function index() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'List of Roles',
        'roles' => $this->model('roles_model')->getRoles(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('roles/table-data', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function new() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Create Role',
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('roles/create');
      $this->view('layouts/dashboard/footer');
    }
  }

  public function create() {
    try {
      $result  = $this->model('roles_model')->createRole($_POST);

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
        'title' => 'Edit Role',
        'role' => $this->model('roles_model')->getDataById($id),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('roles/edit', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function update() {
    try {
      $result  = $this->model('roles_model')->update($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function delete() {
    try {
      $result  = $this->model('roles_model')->delete($_POST['id']);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function checkDuplicate() {
    $result = $this->model('roles_model')->getDuplicate($_POST['role_name']);
    if($result) {
      echo $result;
    }
  }
}