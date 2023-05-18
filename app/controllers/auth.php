<?php

class Auth extends Controller {
  public function index() {
    if(isset($_SESSION['userInfo'])) {
      header('Location: ' . BASEURL . '/mom');
    } else {
      $this->view('auth/login');
    }
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

  public function logout() {
    session_unset();
    session_destroy();

    header('Location: ' . BASEURL . '/auth');
  }
}