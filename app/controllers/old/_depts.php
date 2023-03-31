<?php

class Depts extends Controller
{
    public function getAll()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            echo json_encode($this->model('depts_model')->getAll());
        }
    }

    public function index()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $data = [
                'title' => 'Master Departments'
            ];

            $this->view('templates/header', $data);
            $this->view('master/depts/index');
            $this->view('templates/footer');
        }
    }

    public function store()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('depts_model')->store($_POST);
            if($execute > 0) {
                $feedback['alertClass'] = 'alert alert-success alert-dismissible fade show';
                $feedback['alertMsg'] = 'Berhasil menambahkan data';
                echo json_encode($feedback);
            } else {
                $feedback['alertClass'] = 'alert alert-danger alert-dismissible fade show';
                $feedback['alertMsg'] = 'Gagal menambahkan data !';
                echo json_encode($feedback);
            }
        }
    }

    public function update()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('depts_model')->update($_POST);
            if($execute > 0) {
                $feedback['alertClass'] = 'alert alert-success alert-dismissible fade show';
                $feedback['alertMsg'] = 'Berhasil merubah data';
                echo json_encode($feedback);
            } else {
                $feedback['alertClass'] = 'alert alert-danger alert-dismissible fade show';
                $feedback['alertMsg'] = 'Tidak terdeteksi perubahan !';
                echo json_encode($feedback);
            }
        }
    }

    public function destroy()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('depts_model')->delete($_POST['id']);
            if($execute > 0) {
                $feedback['alertClass'] = 'alert alert-success alert-dismissible fade show';
                $feedback['alertMsg'] = 'Berhasil menghapus data';
                echo json_encode($feedback);
            } else {
                $feedback['alertClass'] = 'alert alert-danger alert-dismissible fade show';
                $feedback['alertMsg'] = 'Gagal menghapus data !';
                echo json_encode($feedback);
            }
        }
    }

    public function validate()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('depts_model')->validate($_POST['dept_name']);
            echo json_encode($execute);
        }
    }

    public function getDataById()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('depts_model')->getDataById($_POST['id']);
            echo json_encode($execute);
        }
    }

    public function search()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('depts_model')->search($_POST['keywords']);
            echo json_encode($execute);
        }
    }
}