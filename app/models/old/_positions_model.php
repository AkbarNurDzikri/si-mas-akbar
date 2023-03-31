<?php

class Positions_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAll()
    {
        $this->db->query("SELECT * FROM master_positions ORDER BY position_name ASC");
        return $this->db->resultSet();
    }

    public function store($data)
    {
        $query = "INSERT INTO master_positions VALUES ('', :position_name)";

        $this->db->query($query);
        $this->db->bind('position_name', $data['position_name']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function update($data)
    {
        $query = "UPDATE master_positions SET
            position_name = :position_name
        WHERE id = :id
        ";

        $this->db->query($query);
        $this->db->bind('position_name', $data['position_name']);
        $this->db->bind('id', $data['id']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($id)
    {
        $query = "DELETE FROM master_positions WHERE id = :id";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function validate($data)
    {
        $this->db->query("SELECT * FROM master_positions WHERE position_name = :position_name");
        $this->db->bind('position_name', $data);
        return $this->db->single();
    }

    public function getDataById($id)
    {
        $this->db->query("SELECT * FROM master_positions WHERE id = :id");
        $this->db->bind('id', $id);
        return $this->db->single();
    }

    public function search($keywords)
    {
        $this->db->query("SELECT * FROM master_positions WHERE position_name LIKE :position_name");
        $this->db->bind('position_name', "%$keywords%");
        return $this->db->resultSet();
    }
}
