<?php

class Users extends Controller {  
  public function index() {
    $data = [
      'title' => 'List of Users',
      'users' => $this->model('users_model')->getUsers(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('users/table-data', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function new() {
    $data = [
      'title' => 'Create User',
      'roles' => $this->model('roles_model')->getRoles(),
      'members' => $this->model('members_model')->getMembers(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('users/create', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function create() {
    try {
      $result  = $this->model('users_model')->createUser($_POST);

      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function edit($id) {
    $data = [
      'title' => 'Edit User',
      'user' => $this->model('users_model')->getDataById($id),
      'roles' => $this->model('roles_model')->getRoles(),
      'members' => $this->model('members_model')->getMembers(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('users/edit', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function update() {
    var_dump($_POST);
    // try {
    //   $result  = $this->model('users_model')->update($_POST);
    //   if($result > 0) {
    //     echo 'success';
    //   }
    // } catch(Exception $e) {
    //   echo $e->getMessage();
    // }
  }

  public function delete() {
    try {
      $result  = $this->model('users_model')->delete($_POST['id']);
      if($result > 0) {
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function checkPassword() {
    $username = $this->model('users_model')->getDataByUsername($_POST['username']);
    $validate = password_verify($_POST['password'], $username['password']);
    if($validate) {
      echo true;
    }
  }

  public function changeCredentials() {
    try {
      $result = $this->model('users_model')->changeCredentials($_POST);
      if($result > 0) {
        echo 'success';
      }
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
}