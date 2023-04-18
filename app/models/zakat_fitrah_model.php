<?php

class Zakat_fitrah_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getLengthFitrahUang() {
		$this->db->query("SELECT COUNT(`id`) AS data_rows FROM zakat_fitrah WHERE qty_out IS NULL AND zakat_type = 'Uang'");
		return $this->db->resultSet();
	}

	public function getUangMasukAjax($order, $dir, $limit, $start) {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_out IS NULL AND zakat_type = 'Uang' ORDER BY $order $dir LIMIT $limit OFFSET $start");
		return $this->db->resultSet();
	}

	public function getFitrahUangMasukSearch($keyword) {
		$this->db->query("SELECT COUNT(`id`) AS data_rows FROM zakat_fitrah WHERE qty_out IS NULL AND zakat_type = 'Uang' AND person_name LIKE :keyword");

		$this->db->bind('keyword', "%$keyword%");
		return $this->db->resultSet();
	}

	public function getUangMasukAjaxSearch($order, $dir, $limit, $start, $keyword) {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_out IS NULL AND zakat_type = 'Uang' AND z.person_name LIKE :keyword OR z.person_address LIKE :keyword OR z.created_at LIKE :keyword OR z.qty_in LIKE :keyword OR z.remarks LIKE :keyword OR u.username LIKE :keyword ORDER BY $order $dir LIMIT $limit OFFSET $start");

		$this->db->bind('keyword', "%$keyword%");
		return $this->db->resultSet();
	}

	// Zakat Uang
	public function getUangMasuk() {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_out IS NULL AND zakat_type = 'Uang' ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function getUangMasukBetweenDate($params) {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.created_at BETWEEN :start_date AND :end_date AND z.qty_out IS NULL AND zakat_type = 'Uang' ORDER BY created_at DESC");
		
		$this->db->bind('start_date', $params['start_date'] . ' 0:00:00');
		$this->db->bind('end_date', $params['end_date'] . ' 23:59:59');
		return $this->db->resultSet();
	}

	public function getUangKeluar() {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_in IS NULL AND zakat_type = 'Uang' ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function getUangKeluarBetweenDate($params) {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.created_at BETWEEN :start_date AND :end_date AND z.qty_in IS NULL AND zakat_type = 'Uang' ORDER BY created_at DESC");
		
		$this->db->bind('start_date', $params['start_date'] . ' 0:00:00');
		$this->db->bind('end_date', $params['end_date'] . ' 23:59:59');
		return $this->db->resultSet();
	}

	public function createZakat($data) {
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

	public function updateZakat($data) {
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

	public function deleteZakat($id) {
		$query = "DELETE FROM zakat_fitrah WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}
	// Zakat Uang

	// Zakat Beras
	public function getBerasMasuk() {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_out IS NULL AND zakat_type = 'Beras' ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function getBerasMasukBetweenDate($params) {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.created_at BETWEEN :start_date AND :end_date AND z.qty_out IS NULL AND zakat_type = 'Beras' ORDER BY created_at DESC");
		
		$this->db->bind('start_date', $params['start_date'] . ' 0:00:00');
		$this->db->bind('end_date', $params['end_date'] . ' 23:59:59');
		return $this->db->resultSet();
	}

	public function getBerasKeluar() {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_in IS NULL AND zakat_type = 'Beras' ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function getBerasKeluarBetweenDate($params) {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.created_at BETWEEN :start_date AND :end_date AND z.qty_in IS NULL AND zakat_type = 'Beras' ORDER BY created_at DESC");
		
		$this->db->bind('start_date', $params['start_date'] . ' 0:00:00');
		$this->db->bind('end_date', $params['end_date'] . ' 23:59:59');
		return $this->db->resultSet();
	}
}
