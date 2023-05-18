<?php

class Categories extends Controller {
  public function index() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Post Categories',
        'categories' => $this->model('categories_model')->getAll(),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('blog/categories/table-data', $data);
      $this->view('layouts/dashboard/footer');
    }
  }

  public function new() {
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Create Category',
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('blog/categories/create');
      $this->view('layouts/dashboard/footer');
    }
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
    if(!isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/auth');
    } else {
      $data = [
        'title' => 'Edit Category',
        'category' => $this->model('categories_model')->getDataById($id),
      ];

      $this->view('layouts/dashboard/header', $data);
      $this->view('blog/categories/edit', $data);
      $this->view('layouts/dashboard/footer');
    }
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