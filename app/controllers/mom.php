<?php

class Mom extends Controller {
  public function index() {
    $data = [
      'title' => 'Minutes of Meeting',
      'moms' => $this->model('mom_model')->getMoms(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('minutes-of-meeting/table-data', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function new() {
    $data = [
      'title' => 'Create Notes',
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('minutes-of-meeting/create');
    $this->view('layouts/dashboard/footer');
  }

  public function create() {
    try {
      $result  = $this->model('categories_model')->create($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function edit($id) {
    $data = [
      'title' => 'Edit Category',
      'category' => $this->model('categories_model')->getDataById($id),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('blog/categories/edit', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function update() {
    try {
      $result  = $this->model('categories_model')->update($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function delete() {
    try {
      $result  = $this->model('categories_model')->delete($_POST['id']);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function checkDuplicate() {
    $result = $this->model('categories_model')->getDuplicate($_POST['category_name']);
    if($result) {
      echo $result;
    }
  }
}