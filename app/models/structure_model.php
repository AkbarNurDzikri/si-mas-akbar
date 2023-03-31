<?php

class Structure_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getStructure() {
		$this->db->query("SELECT dkms.id, m.member_name, l.member_name AS leader_name FROM dkm_structure AS dkms INNER JOIN dkm_members AS m ON m.id = dkms.child_id INNER JOIN dkm_members AS l ON l.id = dkms.parent_id");
		return $this->db->resultSet();
	}

	public function createStructure($data) {
		$query = "INSERT INTO dkm_structure VALUES ('', :child_id, :parent_id, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('child_id', $data['child_id']);
		$this->db->bind('parent_id', $data['parent_id']);
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDataById($id) {
		$this->db->query("SELECT dkms.id, m.id AS member_id, m.member_name, l.id AS leader_id, l.member_name AS leader_name FROM dkm_structure AS dkms INNER JOIN dkm_members AS m ON m.id = dkms.child_id INNER JOIN dkm_members AS l ON l.id = dkms.parent_id WHERE dkms.id = :id");
		$this->db->bind('id', $id);
		return $this->db->single();
	}

	public function update($data) {
		$query = "UPDATE dkm_structure SET
			child_id = :child_id,
			parent_id = :parent_id,
			updated_at = :updated_at
		WHERE id = :id";

		$this->db->query($query);
		$this->db->bind('child_id', $data['child_id']);
		$this->db->bind('parent_id', $data['parent_id']);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function delete($id) {
		$query = "DELETE FROM dkm_structure WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}
}
