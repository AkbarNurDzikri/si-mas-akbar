<?php

class Zakat_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getZakatFitrahUang() {
		$this->db->query("SELECT z.*, u.username FROM zakat_fitrah AS z INNER JOIN users AS u ON u.id = z.created_by WHERE z.qty_out IS NULL ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function createFitrah($data) {
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

	public function getDataById($eventId) {
		$this->db->query("SELECT eb.*, ev.event_name, ev.event_date, ev.event_time, ev.event_location, mom.title, mom.meeting_date, mom.meeting_time, mom.meeting_room, mom.meeting_participants FROM event_budgeting AS eb INNER JOIN events AS ev ON ev.id = eb.event_id INNER JOIN minutes_of_meetings AS mom ON mom.id = ev.ref_meeting WHERE eb.event_id = :id");

		$this->db->bind('id', $eventId);
		return $this->db->resultSet();
	}

	public function update($data) {
		$query = "UPDATE event_budgeting SET
				updated_by = :updated_by,
				budget_name = :budget_name,
				budget_price = :budget_price,
				remarks = :remarks,
				updated_at = :updated_at
		WHERE id = :id
		";

		$this->db->query($query);
		$this->db->bind('updated_by', $_SESSION['userInfo']['id']);
		$this->db->bind('budget_name', $data['budget_name']);
		$this->db->bind('budget_price', $data['budget_price']);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function delete($id) {
		$query = "DELETE FROM event_budgeting WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}
}
