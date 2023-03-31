<?php

class Auth extends Controller {
  public function index() {
    $this->view('auth/login');
  }

  public function checkCredentials() {
    $uname = $_POST['username'];
    $passw = $_POST['password'];

    $checkUnameExist = $this->model('users_model')->getDataByUsername($uname);
    if($checkUnameExist) {
      $verifyPassw = password_verify($passw, $checkUnameExist['password']);
      if($verifyPassw) {
        echo 'success';
        $_SESSION['userInfo'] = $checkUnameExist;
      } else {
        echo 'failed';
      }
    } else {
      echo 'failed';
    }
  }
}