<?php

class Users_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll()
    {
        $this->db->query("SELECT u.username, u.id, e.id AS emp_id, e.emp_name, d.id AS dept_id, d.dept_name, p.id AS position_id, p.position_name FROM master_users AS u INNER JOIN master_employees AS e ON e.id = u.emp_id INNER JOIN master_depts AS d ON d.id = u.dept_id INNER JOIN master_positions AS p ON p.id = u.position_id ORDER BY e.emp_name ASC");
        return $this->db->resultSet();
    }

    public function store($data)
    {
        $query = "INSERT INTO master_users VALUES ('', :emp_id, :dept_id, :position_id, :username, :password)";

        $this->db->query($query);
        $this->db->bind('emp_id', $data['emp_id']);
        $this->db->bind('dept_id', $data['dept_id']);
        $this->db->bind('position_id', $data['position_id']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data)
    {
        $query = "UPDATE master_users SET
            emp_id = :emp_id,
            dept_id = :dept_id,
            position_id = :position_id,
            username = :username,
            password = :password
        WHERE id = :id
        ";

        $this->db->query($query);
        $this->db->bind('emp_id', $data['emp_id']);
        $this->db->bind('dept_id', $data['dept_id']);
        $this->db->bind('position_id', $data['position_id']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($id)
    {
        $query = "DELETE FROM master_users WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function validate($data)
    {
        $this->db->query("SELECT * FROM master_users WHERE username = :username");
        $this->db->bind('username', $data);
        return $this->db->single();
    }

    public function getDataById($id)
    {
        $this->db->query("SELECT * FROM master_users WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function search($keywords)
    {
        $this->db->query("SELECT u.username, u.id, e.id AS emp_id, e.emp_name, d.id AS dept_id, d.dept_name, p.id AS position_id, p.position_name FROM master_users AS u INNER JOIN master_employees AS e ON e.id = u.emp_id INNER JOIN master_depts AS d ON d.id = u.dept_id INNER JOIN master_positions AS p ON p.id = u.position_id WHERE u.username LIKE :keywords OR e.emp_name LIKE :keywords OR dept_name LIKE :keywords OR position_name LIKE :keywords ORDER BY e.emp_name ASC");
        $this->db->bind('keywords', "%$keywords%");
        return $this->db->resultSet();
    }
}
