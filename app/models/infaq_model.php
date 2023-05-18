<?php

class Infaq_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getInfaqMasuk() {
		$this->db->query("SELECT z.*, u.username FROM infaq AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_out IS NULL ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function getInfaqMasukBetweenDate($params) {
		$this->db->query("SELECT z.*, u.username FROM infaq AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.created_at BETWEEN :start_date AND :end_date AND z.qty_out IS NULL ORDER BY created_at DESC");
		
		$this->db->bind('start_date', $params['start_date'] . ' 0:00:00');
		$this->db->bind('end_date', $params['end_date'] . ' 23:59:59');
		return $this->db->resultSet();
	}

	public function getInfaqMasukAjaxLength() {
		$this->db->query("SELECT COUNT(`id`) AS data_rows FROM infaq WHERE qty_out IS NULL");
		return $this->db->resultSet();
	}

	public function getInfaqMasukAjax($order, $dir, $limit, $start) {
		$this->db->query("SELECT z.*, u.username FROM infaq AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_out IS NULL ORDER BY $order $dir LIMIT $limit OFFSET $start");
		return $this->db->resultSet();
	}

	public function getInfaqMasukAjaxSearchLength($keyword) {
		$this->db->query("SELECT COUNT(z.id) AS data_rows, z.*, u.username FROM infaq AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_out IS NULL AND z.person_name LIKE :keyword");

		$this->db->bind('keyword', "%$keyword%");
		return $this->db->resultSet();
	}

	public function getInfaqMasukAjaxSearch($order, $dir, $limit, $start, $keyword) {
		$this->db->query("SELECT z.*, u.username FROM infaq AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_out IS NULL AND z.person_name LIKE :keyword ORDER BY $order $dir LIMIT $limit OFFSET $start");

		$this->db->bind('keyword', "%$keyword%");
		return $this->db->resultSet();
	}

	public function getInfaqKeluar() {
		$this->db->query("SELECT z.*, u.username FROM infaq AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_in IS NULL ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function getInfaqKeluarBetweenDate($params) {
		$this->db->query("SELECT z.*, u.username FROM infaq AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.created_at BETWEEN :start_date AND :end_date AND z.qty_in IS NULL ORDER BY created_at DESC");
		
		$this->db->bind('start_date', $params['start_date'] . ' 0:00:00');
		$this->db->bind('end_date', $params['end_date'] . ' 23:59:59');
		return $this->db->resultSet();
	}

	public function getInfaqKeluarAjaxLength() {
		$this->db->query("SELECT COUNT(`id`) AS data_rows FROM infaq WHERE qty_in IS NULL");
		return $this->db->resultSet();
	}

	public function getInfaqKeluarAjax($order, $dir, $limit, $start) {
		$this->db->query("SELECT z.*, u.username FROM infaq AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_in IS NULL ORDER BY $order $dir LIMIT $limit OFFSET $start");
		return $this->db->resultSet();
	}

	public function getInfaqKeluarAjaxSearchLength($keyword) {
		$this->db->query("SELECT COUNT(z.id) AS data_rows, z.*, u.username FROM infaq AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_in IS NULL AND z.person_name LIKE :keyword");

		$this->db->bind('keyword', "%$keyword%");
		return $this->db->resultSet();
	}

	public function getInfaqKeluarAjaxSearch($order, $dir, $limit, $start, $keyword) {
		$this->db->query("SELECT z.*, u.username FROM infaq AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_in IS NULL AND z.person_name LIKE :keyword ORDER BY $order $dir LIMIT $limit OFFSET $start");

		$this->db->bind('keyword', "%$keyword%");
		return $this->db->resultSet();
	}

	public function createInfaq($data) {
		$query = "INSERT INTO infaq VALUES (NULL, :created_by, :updated_by, :person_name, :person_address, :qty_in, :qty_out, :remarks, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('created_by',  $_SESSION['userInfo']['id']);
		$this->db->bind('updated_by',  NULL);
		$this->db->bind('person_name', $data['person_name']);
		$this->db->bind('person_address', $data['person_address']);
		$this->db->bind('qty_in', isset($data['qty_in']) ? $data['qty_in'] : NULL);
		$this->db->bind('qty_out', isset($data['qty_out']) ? $data['qty_out'] : NULL);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDataById($id) {
		$this->db->query("SELECT * FROM infaq WHERE id = :id");

		$this->db->bind('id', $id);
		return $this->db->resultSet();
	}

	public function updateInfaq($data) {
		$query = "UPDATE infaq SET
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

	public function deleteInfaq($id) {
		$query = "DELETE FROM infaq WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}
}
