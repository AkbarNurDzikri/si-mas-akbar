<?php

class Status_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM master_status ORDER BY status_name ASC");
        return $this->db->resultSet();
    }

    public function store($data)
    {
        $query = "INSERT INTO master_status VALUES ('', :status_name)";

        $this->db->query($query);
        $this->db->bind('status_name', $data['status_name']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data)
    {
        $query = "UPDATE master_status SET
            status_name = :status_name
        WHERE id = :id
        ";

        $this->db->query($query);
        $this->db->bind('status_name', $data['status_name']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($id)
    {
        $query = "DELETE FROM master_status WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function validate($data)
    {
        $this->db->query("SELECT * FROM master_status WHERE status_name = :status_name");
        $this->db->bind('status_name', $data);
        return $this->db->single();
    }

    public function getDataById($id)
    {
        $this->db->query("SELECT * FROM master_status WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function search($keywords)
    {
        $this->db->query("SELECT * FROM master_status WHERE status_name LIKE :status_name");
        $this->db->bind('status_name', "%$keywords%");
        return $this->db->resultSet();
    }
}
