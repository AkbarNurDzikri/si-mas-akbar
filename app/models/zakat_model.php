<?php

class Zakat_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getUangMasuk() {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_out IS NULL ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function getUangKeluar() {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_in IS NULL ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function createZakatUang($data) {
		$query = "INSERT INTO zakat_fitrah VALUES ('', :created_by, :updated_by, :person_name, :person_address, :person_status, :zakat_type, :qty_in, :qty_out, :remarks, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('created_by',  $_SESSION['userInfo']['id']);
		$this->db->bind('updated_by',  NULL);
		$this->db->bind('person_name', $data['person_name']);
		$this->db->bind('person_address', $data['person_address']);
		$this->db->bind('person_status', $data['person_status']);
		$this->db->bind('zakat_type', $data['zakat_type']);
		$this->db->bind('qty_in', isset($data['qty_in']) ? $data['qty_in'] : NULL);
		$this->db->bind('qty_out', isset($data['qty_out']) ? $data['qty_out'] : NULL);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDataById($id) {
		$this->db->query("SELECT * FROM zakat_fitrah WHERE id = :id");

		$this->db->bind('id', $id);
		return $this->db->resultSet();
	}

	public function updateZakatUang($data) {
		$query = "UPDATE zakat_fitrah SET
				updated_by = :updated_by,
				person_name = :person_name,
				person_address = :person_address,
				qty_in = :qty_in,
				qty_out = :qty_out,
				remarks = :remarks,
				updated_at = :updated_at
		WHERE id = :id
		";

		$this->db->query($query);
		$this->db->bind('updated_by', $_SESSION['userInfo']['id']);
		$this->db->bind('person_name', $data['person_name']);
		$this->db->bind('person_address', $data['person_address']);
		$this->db->bind('qty_in', isset($data['qty_in']) ? $data['qty_in'] : NULL);
		$this->db->bind('qty_out', isset($data['qty_out']) ? $data['qty_out'] : NULL);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function deleteZakatUang($id) {
		$query = "DELETE FROM zakat_fitrah WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}
}
