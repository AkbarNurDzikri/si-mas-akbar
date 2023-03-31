<?php

class Members_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getMembers() {
		$this->db->query("SELECT * FROM dkm_members ORDER BY member_name ASC");
		return $this->db->resultSet();
	}

	public function createMember($data, $filename) {
		$query = "INSERT INTO dkm_members VALUES ('', :member_name, :member_position, :member_job, :member_image, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('member_name', $data['member_name']);
		$this->db->bind('member_position', $data['member_position']);
		$this->db->bind('member_job', $data['member_job']);
		$this->db->bind('member_image', $filename);
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDataById($id) {
		$this->db->query("SELECT * FROM dkm_members WHERE id = :id");
		$this->db->bind('id', $id);
		return $this->db->single();
	}

	// argument dikirim dari controller members (method update) berbentuk array
	public function update($data) {
		$query = "UPDATE dkm_members SET
			member_name = :member_name,
			member_position = :member_position,
			member_job = :member_job,
			member_image = :member_image,
			updated_at = :updated_at
		WHERE id = :id";

		$this->db->query($query);
		$this->db->bind('member_name', $data[0]['member_name']);
		$this->db->bind('member_position', $data[0]['member_position']);
		$this->db->bind('member_job', $data[0]['member_job']);
		// jika ada image lama (artinya user mengirim image baru) gunakan $data[1] (nama file baru yang sudah di define dari controller), jika tidak ada image lama gunakan $data[0][member_image] sebagai data lama yg sudah exist di database
		$this->db->bind('member_image', isset($data[0]['member_imageOld']) ? $data[1] : $data[0]['member_image']);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data[0]['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function delete($id) {
		$query = "DELETE FROM dkm_members WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDuplicate($keyword) {
		$this->db->query("SELECT * FROM dkm_members WHERE member_position = :member_position");
		$this->db->bind('member_position', $keyword);
		return $this->db->single();
	}
}
