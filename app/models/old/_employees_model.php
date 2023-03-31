<?php

class Employees_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM master_employees ORDER BY emp_name ASC");
        return $this->db->resultSet();
    }

    public function store($data)
    {
        $query = "INSERT INTO master_employees VALUES ('', :emp_name, :join_date, :leave_balance)";

        $this->db->query($query);
        $this->db->bind('emp_name', $data['emp_name']);
        $this->db->bind('join_date', $data['join_date']);
        $this->db->bind('leave_balance', $data['leave_balance']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data)
    {
        $query = "UPDATE master_employees SET
            emp_name = :emp_name,
            join_date = :join_date,
            leave_balance = :leave_balance
        WHERE id = :id
        ";

        $this->db->query($query);
        $this->db->bind('emp_name', $data['emp_name']);
        $this->db->bind('join_date', $data['join_date']);
        $this->db->bind('leave_balance', $data['leave_balance']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($id)
    {
        $query = "DELETE FROM master_employees WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function validate($data)
    {
        $this->db->query("SELECT * FROM master_employees WHERE emp_name = :emp_name");
        $this->db->bind('emp_name', $data);
        return $this->db->single();
    }

    public function getDataById($id)
    {
        $this->db->query("SELECT * FROM master_employees WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function search($keywords)
    {
        $this->db->query("SELECT * FROM master_employees WHERE emp_name LIKE :keywords OR join_date LIKE :keywords OR leave_balance LIKE :keywords");
        $this->db->bind('keywords', "%$keywords%");
        return $this->db->resultSet();
    }
}
