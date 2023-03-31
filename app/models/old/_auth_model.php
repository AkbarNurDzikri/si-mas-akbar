<?php

class Auth_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getUserInfo($data)
    {
        $this->db->query("SELECT u.id, u.username, u.password, e.id AS emp_id, e.emp_name, e.join_date, e.leave_balance, d.id AS dept_id, d.dept_name, p.id AS position_id, p.position_name FROM master_users AS u INNER JOIN master_employees AS e ON e.id = u.emp_id INNER JOIN master_depts AS d ON d.id = u.dept_id INNER JOIN master_positions AS p ON p.id = u.position_id WHERE username = :uname");
        $this->db->bind('uname', $data);
        return $this->db->single();
    }

    public function update($data)
    {
        $query = "UPDATE master_users SET
            username = :uname,
            password = :passw
        WHERE id = :id
        ";

        $this->db->query($query);
        $this->db->bind('uname', $data['username']);
        $this->db->bind('passw', password_hash($data['new_password'], PASSWORD_DEFAULT));
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function topupLeaveBalance($data)
    {
        // var_dump($data);
        // die();
        $query = "UPDATE master_employees SET topup_leave_balance = :topup WHERE id = :id";

        $this->db->query($query);
        $this->db->bind('topup', $data['topup_leave_balance']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }
}
