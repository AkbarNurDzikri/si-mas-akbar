<?php

class Auth extends Controller {
    public function index() {
        $getUser = $this->model('auth_model')->getUserInfo($_POST['username']);
        if($getUser > 0 && password_verify($_POST['password'], $getUser['password'])) {
            $_SESSION['userInfo'] = $getUser;
            $result = [
                'bool' => 1,
                'target_redirect' => BASEURL . '/dashboard'
            ];

            echo json_encode($result);
        } else {
            echo 0;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASEURL);
    }

    public function setting() {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $data = [
                'title' => 'User Setting'
            ];

            $this->view('templates/header', $data);
            $this->view('master/users/setting', $data);
            $this->view('templates/footer');
        }
    }

    public function checkPassw() {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $getUser = $this->model('auth_model')->getUserInfo($_POST['username']);
            if($getUser > 0 && password_verify($_POST['password'], $getUser['password'])) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    public function changeCredentials() {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('auth_model')->update($_POST);
            if($execute > 0) {
                session_unset();
                session_destroy();
                $feedback['result'] = 1;
                $feedback['message'] = 'Berhasil merubah credentials';
                echo json_encode($feedback);
            } else {
                $feedback['result'] = 0;
                $feedback['message'] = 'Tidak terdeteksi perubahan !';
                echo json_encode($feedback);
            }
        }
    }

    public function getUserLive() {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute = $this->model('auth_model')->getUserInfo($_POST['username']);
            echo json_encode($execute);
        }
    }
}