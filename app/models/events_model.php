<?php

class Events_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getEvents() {
		$this->db->query("SELECT e.*, c.username AS creator, ed.username AS editor, m.title AS ref_meeting_title FROM events AS e INNER JOIN users AS c ON c.id = e.created_by LEFT JOIN users AS ed ON ed.id = e.updated_by INNER JOIN minutes_of_meetings AS m ON m.id = e.ref_meeting ORDER BY e.created_at DESC");
		return $this->db->resultSet();
	}

	public function create($data) {
		$query = "INSERT INTO events VALUES ('', :ref_meeting, :created_by, :updated_by, :event_name, :event_date, :event_time, :event_location, :remarks, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('ref_meeting', $data['ref_meeting']);
		$this->db->bind('created_by',  $_SESSION['userInfo']['id']);
		$this->db->bind('updated_by',  NULL);
		$this->db->bind('event_name', $data['event_name']);
		$this->db->bind('event_date', $data['event_date']);
		$this->db->bind('event_time', $data['event_time']);
		$this->db->bind('event_location', $data['event_location']);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDataById($id) {
		$this->db->query("SELECT e.*, m.title FROM events AS e INNER JOIN minutes_of_meetings AS m on m.id = e.ref_meeting WHERE e.id = :id");
		$this->db->bind('id', $id);
		return $this->db->single();
	}

	public function update($data) {
		$query = "UPDATE events SET
				ref_meeting = :ref_meeting,
				updated_by = :updated_by,
				event_name = :event_name,
				event_date = :event_date,
				event_time = :event_time,
				event_location = :event_location,
				remarks = :remarks,
				updated_at = :updated_at
		WHERE id = :id
		";

		$this->db->query($query);
		$this->db->bind('ref_meeting', $data['ref_meeting']);
		$this->db->bind('updated_by',  $_SESSION['userInfo']['id']);
		$this->db->bind('event_name', $data['event_name']);
		$this->db->bind('event_date', $data['event_date']);
		$this->db->bind('event_time', $data['event_time']);
		$this->db->bind('event_location', $data['event_location']);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function delete($id) {
		$query = "DELETE FROM events WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}
}
