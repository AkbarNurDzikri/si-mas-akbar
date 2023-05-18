<?php

class Roles_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getRoles() {
		$this->db->query("SELECT * FROM roles ORDER BY role_name ASC");
		return $this->db->resultSet();
	}

	public function createRole($data) {
		$query = "INSERT INTO roles VALUES (NULL, :role_name, :remarks, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('role_name', $data['role_name']);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDataById($id) {
		$this->db->query("SELECT * FROM roles WHERE id = :id");
		$this->db->bind('id', $id);
		return $this->db->single();
	}

	public function update($data) {
		$query = "UPDATE roles SET
			role_name = :role_name,
			remarks = :remarks,
			updated_at = :updated_at
		WHERE id = :id";

		$this->db->query($query);
		$this->db->bind('role_name', $data['role_name']);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function delete($id) {
		$query = "DELETE FROM roles WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDuplicate($keyword) {
		$this->db->query("SELECT * FROM roles WHERE role_name = :role_name");
		$this->db->bind('role_name', $keyword);
		return $this->db->single();
	}
}
