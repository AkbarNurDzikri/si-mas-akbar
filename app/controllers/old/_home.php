<?php

class Home extends Controller {
    public function index() {
        if(isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL . '/dashboard');
        } else {
            $this->view('home/index');
        }
    }
}