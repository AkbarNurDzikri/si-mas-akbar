<?php

class Categories_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getAll() {
		$this->db->query("SELECT * FROM postcategories ORDER BY category_name ASC");
		return $this->db->resultSet();
	}

	public function create($data) {
		$query = "INSERT INTO postcategories VALUES (NULL, :category_name, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('category_name', $data['category_name']);
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDataById($id) {
		$this->db->query("SELECT * FROM postcategories WHERE id = :id");
		$this->db->bind('id', $id);
		return $this->db->single();
	}

	public function update($data) {
		$query = "UPDATE postcategories SET
				category_name = :category_name,
				updated_at = :updated_at
		WHERE id = :id
		";

		$this->db->query($query);
		$this->db->bind('category_name', $data['category_name']);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function delete($id) {
		$query = "DELETE FROM postcategories WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDuplicate($keyword) {
		$this->db->query("SELECT * FROM postcategories WHERE category_name = :category_name");
		$this->db->bind('category_name', $keyword);
		return $this->db->single();
	}
}
