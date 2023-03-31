<?php

class Members extends Controller {  
  public function index() {
    $data = [
      'title' => 'List of DKM Members',
      'members' => $this->model('members_model')->getMembers(),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('dkm/members/table-data', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function new() {
    $data = [
      'title' => 'Create Member',
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('dkm/members/create');
    $this->view('layouts/dashboard/footer');
  }

  public function create() {
    try {
      $filename = $_FILES['member_image']['name'];
      $destinationFile = __DIR__ . '/../../assets/images/dkm/members/';
      $result  = $this->model('members_model')->createMember($_POST, $filename);

      if($result > 0) {
        echo 'success';
        move_uploaded_file($_FILES['member_image']['tmp_name'], $destinationFile . $filename);
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function edit($id) {
    $data = [
      'title' => 'Edit Member',
      'member' => $this->model('members_model')->getDataById($id),
    ];

    $this->view('layouts/dashboard/header', $data);
    $this->view('dkm/members/edit', $data);
    $this->view('layouts/dashboard/footer');
  }

  public function update() {
    try {
      // jika image diganti
      if(isset($_POST['member_imageOld'])) {
        // tangkap image baru yg dikirim oleh user melalui form
        $filename = $_FILES['member_image']['name'];
        // tentukan direktori dimana image akan disimpan
        $destinationFile = __DIR__ . '/../../assets/images/dkm/members/';
        // update data baru ke database
        $result  = $this->model('members_model')->update([$_POST, $filename]);

        // jika update berhasil
        if($result > 0) {
          // siapkan image lama untuk dihapus
          $getOldImage = $_POST['member_imageOld'];
          $imageExist = __DIR__ . '/../../assets/images/dkm/members/' . $getOldImage;

          // hapus image lama
          unlink($imageExist);

          // simpan image baru kedalam direktori yang ditentukan diatas
          move_uploaded_file($_FILES['member_image']['tmp_name'], $destinationFile . $filename);
          echo 'success';
        }
      } else {
        $result  = $this->model('members_model')->update([$_POST]);
        if($result > 0) {
          echo 'success';
        }
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function delete() {
    try {
      // hapus data dari database
      $result  = $this->model('members_model')->delete($_POST['id']);

      // jika data berhasil dihapus
      if($result > 0) {
        // siapkan image untuk dihapus
        $getOldImage = $_POST['member_image'];
        $imageExist = __DIR__ . '/../../assets/images/dkm/members/' . $getOldImage;

        // hapus image
        unlink($imageExist);
        echo 'success';
      }
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function checkDuplicate() {
    $result = $this->model('members_model')->getDuplicate($_POST['member_position']);
    if($result) {
      echo $result;
    }
  }
}