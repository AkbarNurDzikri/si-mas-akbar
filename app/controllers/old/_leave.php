<?php

class Leave extends Controller
{
    public function getAll()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            echo json_encode($this->model('employees_model')->getAll());
        }
    }

    public function saldoCutiKaryawan()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $data = [
                'title' => 'Saldo Cuti Karyawan'
            ];

            $this->view('templates/header', $data);
            $this->view('leave/saldoCutiKaryawan');
            $this->view('templates/footer');
        }
    }

    public function search()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('employees_model')->search($_POST['keywords']);
            echo json_encode($execute);
        }
    }

    public function index()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $data = [
                'title' => 'Cuti Saya',
                'getLeaveTopup' => $this->model('leave_model')->getLeaveTopup($_SESSION['userInfo']['emp_id']),
                'getLeaveBalance' => $this->model('leave_model')->getLeaveBalance($_SESSION['userInfo']['emp_id']),
                'getAtasan' => $this->model('leave_model')->getAtasan(),
                'myLeave' => $this->model('leave_model')->getMyLeave($_SESSION['userInfo']['emp_id'])
            ];

            $this->view('templates/header', $data);
            $this->view('leave/index', $data);
            $this->view('templates/footer');
        }
    }

    public function cutiKaryawan()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $data = [
                'title' => 'Cuti Karyawan',
                'getLeaveTopup' => $this->model('leave_model')->getLeaveTopup($_SESSION['userInfo']['emp_id']),
                'getLeaveBalance' => $this->model('leave_model')->getLeaveBalance($_SESSION['userInfo']['emp_id']),
                'getAtasan' => $this->model('leave_model')->getAtasan(),
                'empLeave' => $this->model('leave_model')->getEmpLeave($_SESSION['userInfo']['emp_id'])
            ];

            $this->view('templates/header', $data);
            $this->view('leave/cutiKaryawan', $data);
            $this->view('templates/footer');
        }
    }

    public function topupCuti()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('leave_model')->topupCuti($_POST);
            if($execute > 0) {
                $feedback['icon'] = 'success';
                $feedback['title'] = 'Selamat, Anda mendapatkan hak cuti tahunan sebanyak 12 hari !';
                $feedback['text'] = 'Hak cuti ini diberikan setelah masa kerja mencapai 1 tahun untuk tahun pertama dan setiap awal tahun untuk tahun berikutnya. Manfaatkan hak cuti Anda untuk istirahat bersama keluarga atau sekedar menghirup segarnya udara di tempat wisata';
                echo json_encode($feedback);
            } else {
                $feedback['icon'] = 0;
                $feedback['title'] = 'Gagal menambahkan data !';
                $feedback['text'] = 'Gagal menambahkan data !';
                echo json_encode($feedback);
            }
        }
    }

    public function prosesCuti()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute = $this->model('leave_model')->prosesCuti($_POST);
            if($execute > 0) {
                echo "<script>
                        alert(`Berhasil membuat permohonan cuti \rNote : Cuti Anda akan dianggap sah jika sudah di approve sampai level HRD !`);
                        document.location ='" . BASEURL . '/leave' . "'" . "
                    </script>";
            } else {
                echo "<script>
                        alert(`Gagal membuat permohonan cuti \rHubungi HRD untuk info lebih lanjut !`);
                        document.location ='" . BASEURL . '/leave' . "'" . "
                    </script>";
            }
        }
    }

    public function getEdit()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $result = $this->model('leave_model')->getEdit($_POST['id']);
            echo json_encode($result);
        }
    }

    public function update()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('leave_model')->updateCuti($_POST);
            if($execute > 0) {
                echo "<script>
                        alert(`Berhasil merubah permohonan cuti \rNote : Cuti Anda akan dianggap sah jika sudah di approve sampai level HRD !`);
                        document.location ='" . BASEURL . '/leave' . "'" . "
                    </script>";
            } else {
                echo "<script>
                        alert(`Gagal merubah permohonan cuti \rHubungi HRD untuk info lebih lanjut !`);
                        document.location ='" . BASEURL . '/leave' . "'" . "
                    </script>";
            }
        }
    }

    public function destroy()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('leave_model')->delete($_POST['id']);
            if($execute > 0) {
                $feedback['icon'] = 'success';
                $feedback['title'] = 'Delete data success !';
                $feedback['text'] = 'Data dihapus secara permanen ...';
                echo json_encode($feedback);
            } else {
                $feedback['icon'] = 'error';
                $feedback['title'] = 'Delete data failed !';
                $feedback['text'] = 'Terjadi kesalahan ...';
                echo json_encode($feedback);
            }
        }
    }

    public function approval()
    {
        if(!isset($_SESSION['userInfo'])) {
            header('Location: ' . BASEURL);
        } else {
            $execute  = $this->model('leave_model')->approval($_POST);
            if($execute > 0) {
                echo "<script>
                        alert(`Berhasil memberikan keputusan`);
                        document.location ='" . BASEURL . '/leave/cutiKaryawan' . "'" . "
                    </script>";
            } else {
                echo "<script>
                        alert(`Gagal memberikan keputusan`);
                        document.location ='" . BASEURL . '/leave/cutiKaryawan' . "'" . "
                    </script>";
            }
        }
    }
}