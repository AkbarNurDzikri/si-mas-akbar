<?php

class Event_cash_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getUangMasuk() {
		$this->db->query("SELECT ec.*, u.username, ev.event_name FROM event_cash AS ec INNER JOIN users AS u ON u.id = ec.created_by INNER JOIN events AS ev ON ev.id = ec.ref_event WHERE ec.qty_out IS NULL ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function getKasMasuk($refEvent) {
		$this->db->query("SELECT SUM(qty_in) AS totalKasMasuk FROM event_cash WHERE qty_out IS NULL AND ref_event = :event_id ORDER BY created_at DESC");

		$this->db->bind('event_id', $refEvent);
		return $this->db->resultSet();
	}

	public function getKasKeluar($refEvent) {
		$this->db->query("SELECT SUM(qty_out) AS totalKasKeluar FROM event_cash WHERE qty_in IS NULL AND ref_event = :event_id ORDER BY created_at DESC");

		$this->db->bind('event_id', $refEvent);
		return $this->db->resultSet();
	}

	public function getUangMasukBetweenDate($params, $refEvent) {
		$this->db->query("SELECT ec.*, u.username, ev.event_name FROM event_cash AS ec INNER JOIN users AS u ON u.id = ec.created_by INNER JOIN events AS ev ON ev.id = ec.ref_event WHERE ec.created_at BETWEEN :start_date AND :end_date AND ec.qty_out IS NULL AND ec.ref_event = :event_id ORDER BY created_at DESC");
		
		$this->db->bind('start_date', $params['start_date'] . ' 0:00:00');
		$this->db->bind('end_date', $params['end_date'] . ' 23:59:59');
		$this->db->bind('event_id', $refEvent);
		return $this->db->resultSet();
	}

	public function getUangMasukAjaxLength() {
		$this->db->query("SELECT COUNT(`id`) AS data_rows FROM event_cash WHERE qty_out IS NULL");
		return $this->db->resultSet();
	}

	public function getUangMasukAjax($order, $dir, $limit, $start) {
		$this->db->query("SELECT ec.*, u.username, ev.event_name FROM event_cash AS ec INNER JOIN users AS u ON u.id = ec.created_by INNER JOIN events AS ev ON ev.id = ec.ref_event WHERE ec.qty_out IS NULL ORDER BY $order $dir LIMIT $limit OFFSET $start");
		return $this->db->resultSet();
	}

	public function getUangMasukAjaxSearchLength($keyword) {
		$this->db->query("SELECT COUNT(ec.id) AS data_rows, ec.*, u.username, ev.event_name FROM event_cash AS ec INNER JOIN users AS u ON u.id = ec.created_by INNER JOIN events AS ev ON ev.id = ec.ref_event WHERE ec.qty_out IS NULL AND ev.event_name LIKE :keyword");

		$this->db->bind('keyword', "%$keyword%");
		return $this->db->resultSet();
	}

	public function getUangMasukAjaxSearch($order, $dir, $limit, $start, $keyword) {
		$this->db->query("SELECT ec.*, u.username, ev.event_name FROM event_cash AS ec INNER JOIN users AS u ON u.id = ec.created_by INNER JOIN events AS ev ON ev.id = ec.ref_event WHERE ec.qty_out IS NULL AND ev.event_name LIKE :keyword ORDER BY $order $dir LIMIT $limit OFFSET $start");

		$this->db->bind('keyword', "%$keyword%");
		return $this->db->resultSet();
	}

	public function getUangKeluar() {
		$this->db->query("SELECT ec.*, u.username, ev.event_name FROM event_cash AS ec INNER JOIN users AS u ON u.id = ec.created_by INNER JOIN events AS ev ON ev.id = ec.ref_event WHERE ec.qty_in IS NULL ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function getUangKeluarBetweenDate($params, $refEvent) {
		$this->db->query("SELECT ec.*, u.username, ev.event_name FROM event_cash AS ec INNER JOIN users AS u ON u.id = ec.created_by INNER JOIN events AS ev ON ev.id = ec.ref_event WHERE ec.created_at BETWEEN :start_date AND :end_date AND ec.qty_in IS NULL AND ec.ref_event = :event_id ORDER BY created_at DESC");
		
		$this->db->bind('event_id', $refEvent);
		$this->db->bind('start_date', $params['start_date'] . ' 0:00:00');
		$this->db->bind('end_date', $params['end_date'] . ' 23:59:59');
		return $this->db->resultSet();
	}

	public function getUangKeluarAjaxLength() {
		$this->db->query("SELECT COUNT(`id`) AS data_rows FROM event_cash WHERE qty_in IS NULL");
		return $this->db->resultSet();
	}

	public function getUangKeluarAjax($order, $dir, $limit, $start) {
		$this->db->query("SELECT ec.*, u.username, ev.event_name FROM event_cash AS ec INNER JOIN users AS u ON u.id = ec.created_by INNER JOIN events AS ev ON ev.id = ec.ref_event WHERE ec.qty_in IS NULL ORDER BY $order $dir LIMIT $limit OFFSET $start");
		return $this->db->resultSet();
	}

	public function getUangKeluarAjaxSearchLength($keyword) {
		$this->db->query("SELECT COUNT(ec.id) AS data_rows, ec.*, u.username, ev.event_name FROM event_cash AS ec INNER JOIN users AS u ON u.id = ec.created_by INNER JOIN events AS ev ON ev.id = ec.ref_event WHERE ec.qty_in IS NULL AND ec.person_name LIKE :keyword");

		$this->db->bind('keyword', "%$keyword%");
		return $this->db->resultSet();
	}

	public function getUangKeluarAjaxSearch($order, $dir, $limit, $start, $keyword) {
		$this->db->query("SELECT ec.*, u.username, ev.event_name FROM event_cash AS ec INNER JOIN users AS u ON u.id = ec.created_by INNER JOIN events AS ev ON ev.id ec.ref_event WHERE ec.qty_in IS NULL AND ec.person_name LIKE :keyword ORDER BY $order $dir LIMIT $limit OFFSET $start");

		$this->db->bind('keyword', "%$keyword%");
		return $this->db->resultSet();
	}

	public function createKasAcara($data) {
		$query = "INSERT INTO event_cash VALUES (NULL, :ref_event, :created_by, :updated_by, :remarks, :qty_in, :qty_out, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('created_by',  $_SESSION['userInfo']['id']);
		$this->db->bind('ref_event',  $data['ref_event']);
		$this->db->bind('updated_by',  NULL);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('qty_in', isset($data['qty_in']) ? $data['qty_in'] : NULL);
		$this->db->bind('qty_out', isset($data['qty_out']) ? $data['qty_out'] : NULL);
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDataById($id) {
		$this->db->query("SELECT ec.*, ev.id AS event_id, ev.event_name FROM event_cash AS ec INNER JOIN events AS ev ON ev.id = ec.ref_event WHERE ec.id = :id");

		$this->db->bind('id', $id);
		return $this->db->resultSet();
	}

	public function updateKasAcara($data) {
		$query = "UPDATE event_cash SET
				updated_by = :updated_by,
				ref_event = :ref_event,
				remarks = :remarks,
				qty_in = :qty_in,
				qty_out = :qty_out,
				updated_at = :updated_at
		WHERE id = :id
		";

		$this->db->query($query);
		$this->db->bind('updated_by', $_SESSION['userInfo']['id']);
		$this->db->bind('ref_event', $data['ref_event']);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('qty_in', isset($data['qty_in']) ? $data['qty_in'] : NULL);
		$this->db->bind('qty_out', isset($data['qty_out']) ? $data['qty_out'] : NULL);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function deleteKasAcara($id) {
		$query = "DELETE FROM event_cash WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}
}
