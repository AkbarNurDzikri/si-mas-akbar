<?php

class Users extends Controller
{
    public function getAll()
    {
        echo json_encode($this->model('users_model')->getAll());
    }

    public function index()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $data = [
                'title' => 'Master Users',
                'employees' => $this->model('employees_model')->getAll(),
                'depts' => $this->model('depts_model')->getAll(),
                'positions' => $this->model('positions_model')->getAll()
            ];

            $this->view('templates/header', $data);
            $this->view('master/users/index', $data);
            $this->view('templates/footer');
        }
    }

    public function store()
    {
        $execute  = $this->model('users_model')->store($_POST);
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

    public function update()
    {
        $execute  = $this->model('users_model')->update($_POST);
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

    public function destroy()
    {
        $execute  = $this->model('users_model')->delete($_POST['id']);
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

    public function validate()
    {
        $execute  = $this->model('users_model')->validate($_POST['username']);
        echo json_encode($execute);
    }

    public function getDataById()
    {
        $execute  = $this->model('users_model')->getDataById($_POST['id']);
        echo json_encode($execute);
    }

    public function search()
    {
        $execute  = $this->model('users_model')->search($_POST['keywords']);
        echo json_encode($execute);
    }
}