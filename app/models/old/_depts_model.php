<?php

class Depts_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM master_depts ORDER BY dept_name ASC");
        return $this->db->resultSet();
    }

    public function store($data)
    {
        $query = "INSERT INTO master_depts VALUES ('', :dept_name)";

        $this->db->query($query);
        $this->db->bind('dept_name', $data['dept_name']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data)
    {
        $query = "UPDATE master_depts SET
            dept_name = :dept_name
        WHERE id = :id
        ";

        $this->db->query($query);
        $this->db->bind('dept_name', $data['dept_name']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($id)
    {
        $query = "DELETE FROM master_depts WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function validate($data)
    {
        $this->db->query("SELECT * FROM master_depts WHERE dept_name = :dept_name");
        $this->db->bind('dept_name', $data);
        return $this->db->single();
    }

    public function getDataById($id)
    {
        $this->db->query("SELECT * FROM master_depts WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function search($keywords)
    {
        $this->db->query("SELECT * FROM master_depts WHERE dept_name LIKE :dept_name");
        $this->db->bind('dept_name', "%$keywords%");
        return $this->db->resultSet();
    }
}
