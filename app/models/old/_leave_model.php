<?php

class Leave_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMyLeave($userId)
    {
        $this->db->query("SELECT l.*, user.emp_name, target_approval.emp_name AS target_approval, approved_by.emp_name AS approved_by FROM leave_out AS l INNER JOIN master_employees AS user ON user.id = l.emp_id LEFT JOIN master_employees AS target_approval ON target_approval.id = l.sign_to LEFT JOIN master_employees AS approved_by ON approved_by.id = l.updated_by WHERE l.emp_id = :user_id ORDER BY l.created_at DESC");
        $this->db->bind('user_id', $userId);
        return $this->db->resultSet();
    }

    public function getEmpLeave($userId)
    {
        $this->db->query("SELECT l.*, user.emp_name, target_approval.emp_name AS target_approval, approved_by.emp_name AS approved_by FROM leave_out AS l INNER JOIN master_employees AS user ON user.id = l.emp_id LEFT JOIN master_employees AS target_approval ON target_approval.id = l.sign_to LEFT JOIN master_employees AS approved_by ON approved_by.id = l.updated_by WHERE l.sign_to = :user_id OR l.updated_by = :user_id ORDER BY l.created_at DESC");
        $this->db->bind('user_id', $userId);
        return $this->db->resultSet();
    }

    public function getLeaveTopup($userId)
    {
        $query = "SELECT SUM(number_of_day) AS topup_current_year FROM leave_in WHERE emp_id = :id AND year_stamp = :current_year";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->bind('current_year', date("Y"));
        $this->db->execute();

        return $this->db->single();
    }

    public function topupCuti($data) // finish
    {
        $query = "INSERT INTO leave_in VALUES ('', :emp_id, :number_of_day, :remarks, :year_stamp)";

        $this->db->query($query);
        $this->db->bind('emp_id', $data['emp_id']);
        $this->db->bind('number_of_day', $data['number_of_day']);
        $this->db->bind('remarks', $data['remarks']);
        $this->db->bind('year_stamp', $data['year_stamp']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getLeaveBalance($userId)
    {
        $query = "SELECT leave_balance FROM master_employees WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $userId);
        $this->db->execute();

        return $this->db->single();
    }

    public function uploadLeaveEvidence()
    {
        $file_name = $_FILES['leave_evidence']['name'];
        $file_size = $_FILES['leave_evidence']['size'];
        $error = $_FILES['leave_evidence']['error'];
        $file_temp = $_FILES['leave_evidence']['tmp_name'];

        //validasi gambar diupload
        if ($error === 4) {
            echo "<script>
                    alert(`Evidence tidak terdeteksi ! \rNote : Silahkan masukkan evidence cuti khusus Anda !`);
                    document.location ='" . BASEURL . '/leave' . "'" . "
                </script>";
            return false;
        }

        //validasi ekstensi
        $extGambarValid = ['jpg', 'jpeg', 'png'];
        $extGambar = explode('.', $file_name);
        $getExtGambar = strtolower(end($extGambar));
        if (!in_array($getExtGambar, $extGambarValid)) {
            echo "<script>
                    alert(`Format file tidak didukung ! \rNote : Silahkan upload evidence cuti khusus Anda dengan format file JPG, JPEG atau PNG !`);
                    document.location ='" . BASEURL . '/leave' . "'" . "
                    </script>";
            return false;
        }

        //validasi size gambar
        if ($file_size > 5000000) {
            echo "<script>
                    alert(`File evidence cuti khusus terlalu besar ! \rNote : Maksimal ukuran file 5 MB !`);
                    document.location ='" . BASEURL . '/leave' . "'" . "
                </script>";
                return false;
        }

        //jika lolos validasi, gambar siap diupload
        move_uploaded_file($file_temp, __DIR__ . '/../../public/assets/img/leave_evidences/' . $file_name);
        return $file_name;
    }

    public function prosesCuti($data)
    {
        // var_dump($data);
        // die();
        $query = "INSERT INTO leave_out VALUES ('', :emp_id, :leave_type, :leave_reason, :leave_evidence, :start_date, :end_date, :number_of_day, :has_halfday, :has_holidays, :reason_rejected, :status, :sign_to, :created_by, :updated_by, :created_at, :updated_at)";

        $this->db->query($query);
        $this->db->bind('emp_id', $data['emp_id']);
        $this->db->bind('leave_type', $data['leave_type']);
        $this->db->bind('leave_reason', $data['leave_reason']);
        if($_FILES['leave_evidence']['name'] == '') {
            $this->db->bind('leave_evidence', '');
        } else {
            $this->db->bind('leave_evidence', $this->uploadLeaveEvidence());
            if($this->uploadLeaveEvidence() == false) {
                return false;
                die();
            }
        }
        $this->db->bind('start_date', $data['start_date']);
        $this->db->bind('end_date', $data['end_date']);
        if($data['leave_type'] == 'Annual Leave') {
            $this->db->bind('number_of_day', $data['number_of_day']);
        } else {
            $this->db->bind('number_of_day', 0);
        }
        $this->db->bind('has_halfday', $data['has_halfday']);
        $this->db->bind('has_holidays', $data['has_holidays']);
        $this->db->bind('reason_rejected', '');
        $this->db->bind('status', $data['status'] ?? '');
        $this->db->bind('sign_to', $data['sign_to']);
        $this->db->bind('created_by', $_SESSION['userInfo']['emp_id']);
        $this->db->bind('updated_by', NULL);
        $this->db->bind('created_at', date('Y-m-d h:i:s'));
        $this->db->bind('updated_at', NULL);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function getAtasan()
    {
        $userLevel = $_SESSION['userInfo']['position_name'];
        
        if($userLevel == 'Operator' || $userLevel == 'Helper' || $userLevel == 'Admin') {
            $atasanLevel = 'Leader';
            $this->db->query('SELECT u.emp_id AS atasan_id, e.emp_name AS atasan_name FROM master_users AS u INNER JOIN master_employees AS e ON e.id = u.emp_id INNER JOIN master_positions AS p ON p.id = u.position_id WHERE u.dept_id = :dept_id AND p.position_name = :atasan_level ORDER BY atasan_name ASC');
            $this->db->bind('dept_id', $_SESSION['userInfo']['dept_id']);
            $this->db->bind('atasan_level', $atasanLevel);
            return $this->db->resultSet();
        } else if($userLevel == 'Leader') {
            $atasanLevel = 'Supervisor';
            $this->db->query('SELECT u.emp_id AS atasan_id, e.emp_name AS atasan_name FROM master_users AS u INNER JOIN master_employees AS e ON e.id = u.emp_id INNER JOIN master_positions AS p ON p.id = u.position_id WHERE u.dept_id = :dept_id AND p.position_name = :atasan_level ORDER BY atasan_name ASC');
            $this->db->bind('dept_id', $_SESSION['userInfo']['dept_id']);
            $this->db->bind('atasan_level', $atasanLevel);
            return $this->db->resultSet();
        } else if($userLevel == 'Supervisor' || $userLevel == 'Staff') {
            $atasanLevel = 'Factory Manager';
            $this->db->query('SELECT u.emp_id AS atasan_id, e.emp_name AS atasan_name FROM master_users AS u INNER JOIN master_employees AS e ON e.id = u.emp_id INNER JOIN master_positions AS p ON p.id = u.position_id WHERE p.position_name = :atasan_level ORDER BY atasan_name ASC');
            $this->db->bind('atasan_level', $atasanLevel);
            return $this->db->resultSet();
        } else if($userLevel == 'Factory Manager') {
            $atasanLevel = 'General Manager';
            $this->db->query('SELECT u.emp_id AS atasan_id, e.emp_name AS atasan_name FROM master_users AS u INNER JOIN master_employees AS e ON e.id = u.emp_id INNER JOIN master_positions AS p ON p.id = u.position_id WHERE p.position_name = :atasan_level ORDER BY atasan_name ASC');
            $this->db->bind('atasan_level', $atasanLevel);
            return $this->db->resultSet();
        } else if($userLevel == 'General Manager') {
            $atasanLevel = 'Staff'; // staff disini adalah staff HR/GA, diperkuat oleh clausa where di query
            $this->db->query('SELECT u.emp_id AS atasan_id, e.emp_name AS atasan_name FROM master_users AS u INNER JOIN master_employees AS e ON e.id = u.emp_id INNER JOIN master_positions AS p ON p.id = u.position_id INNER JOIN master_depts AS d ON d.id = u.dept_id WHERE p.position_name = :atasan_level AND d.dept_name = :dept ORDER BY atasan_name ASC');
            $this->db->bind('atasan_level', $atasanLevel);
            $this->db->bind('dept', 'HR/GA');
            return $this->db->resultSet();
        }
    }

    public function getEdit($leaveOut_id)
    {
        $query = "SELECT l.*, user.emp_name, target_approval.emp_name AS target_approval, approved_by.emp_name AS approved_by FROM leave_out AS l INNER JOIN master_employees AS user ON user.id = l.emp_id INNER JOIN master_employees AS target_approval ON target_approval.id = l.sign_to LEFT JOIN master_employees AS approved_by ON approved_by.id = l.updated_by WHERE l.id = :id";
        $this->db->query($query);
        $this->db->bind('id', $leaveOut_id);
        $this->db->execute();

        return $this->db->single();
    }

    public function updateCuti($data)
    {        
        // var_dump($data);
        // die();
        $query = "UPDATE leave_out SET
                    leave_type = :leave_type_edit,
                    leave_reason = :leave_reason,
                    leave_evidence = :leave_evidence,
                    start_date = :start_date,
                    end_date = :end_date,
                    number_of_day = :number_of_day,
                    has_halfday = :has_halfday,
                    has_holidays = :has_holidays,
                    reason_rejected = :reason_rejected,
                    status = :status,
                    sign_to = :sign_to,
                    updated_by = :updated_by,
                    updated_at = :updated_at
                WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('leave_type_edit', $data['leave_type_edit']);
        $this->db->bind('leave_reason', $data['leave_reason']);
        if($_FILES['leave_evidence']['name'] == '') {
            if($data['leave_evidence_old']) {
                $this->db->bind('leave_evidence', $data['leave_evidence_old']);
            } else {
                $this->db->bind('leave_evidence', '');
            }
        } else {
            $this->db->bind('leave_evidence', $this->uploadLeaveEvidence());
            if($this->uploadLeaveEvidence() == false) {
                return false;
                die();
            }
        }
        $this->db->bind('start_date', $data['start_date']);
        $this->db->bind('end_date', $data['end_date']);
        if($data['leave_type_edit'] == 'Annual Leave') {
            $this->db->bind('number_of_day', $data['number_of_day']);
        } else {
            $this->db->bind('number_of_day', 0);
        }
        $this->db->bind('has_halfday', $data['has_halfday']);
        $this->db->bind('has_holidays', $data['has_holidays']);
        $this->db->bind('reason_rejected', $data['reason_rejected'] ?? '');
        $this->db->bind('status', $data['status']);
        $this->db->bind('sign_to', $data['sign_to']);
        $this->db->bind('updated_by', $data['updated_by'] ?? NULL);
        $this->db->bind('updated_at', date('Y-m-d h:i:s'));
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($id) //CHECKED
    {
        $query = "DELETE FROM leave_out WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function approval($data)
    {
        $query = "UPDATE leave_out SET
                    reason_rejected = :reason_rejected,
                    status = :status,
                    sign_to = :sign_to,
                    updated_by = :updated_by,
                    updated_at = :updated_at
                WHERE id = :id";

        $this->db->query($query);
        //$this->db->bind('reason_rejected', $data['reason_rejected'] ?? '');
        $this->db->bind('status', $data['status']);
        if($data['status'] == 'Rejected') {
            $this->db->bind('sign_to', NULL);
          	$this->db->bind('reason_rejected', $data['reason_rejected']);
        } else {
            $this->db->bind('sign_to', $data['sign_to']);
          	$this->db->bind('reason_rejected', '');
        }
        $this->db->bind('updated_by', $data['updated_by']);
        $this->db->bind('updated_at', date('Y-m-d h:i:s'));
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }
}
