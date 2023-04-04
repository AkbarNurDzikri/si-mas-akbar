<?php

class Mom_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getMoms() {
		$this->db->query("SELECT mom.*, creator.username AS creator, editor.username AS editor FROM minutes_of_meetings AS mom INNER JOIN users AS creator ON creator.id = mom.created_by LEFT JOIN users AS editor ON editor.id = mom.updated_by ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function getMomsOpen() {
		$this->db->query("SELECT mom.*, creator.username AS creator, editor.username AS editor FROM minutes_of_meetings AS mom INNER JOIN users AS creator ON creator.id = mom.created_by LEFT JOIN users AS editor ON editor.id = mom.updated_by WHERE mom.status = 'open' ORDER BY created_at DESC");
		return $this->db->resultSet();
	}

	public function create($data) {
		$query = "INSERT INTO minutes_of_meetings VALUES ('', :created_by, :updated_by, :meeting_date, :meeting_time, :meeting_room, :meeting_participants, :title, :body, :status, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('created_by',  $_SESSION['userInfo']['id']);
		$this->db->bind('updated_by',  NULL);
		$this->db->bind('meeting_date', $data['meeting_date']);
		$this->db->bind('meeting_time', $data['meeting_time']);
		$this->db->bind('meeting_room', $data['meeting_room']);
		$this->db->bind('meeting_participants', $data['meeting_participants']);
		$this->db->bind('title', $data['title']);
		$this->db->bind('body', $data['body']);
		$this->db->bind('status', 'open'); // pertama create notulen harus di set open karena belum ada event dilaksanakan yang refer kesini
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDataById($id) {
		$this->db->query("SELECT * FROM minutes_of_meetings WHERE id = :id");
		$this->db->bind('id', $id);
		return $this->db->single();
	}

	public function update($data) {
		$query = "UPDATE minutes_of_meetings SET
				updated_by = :updated_by,
				meeting_date = :meeting_date,
				meeting_time = :meeting_time,
				meeting_room = :meeting_room,
				meeting_participants = :meeting_participants,
				title = :title,
				body = :body,
				status = :status,
				updated_at = :updated_at
		WHERE id = :id
		";

		$this->db->query($query);
		$this->db->bind('updated_by', $_SESSION['userInfo']['id']);
		$this->db->bind('meeting_date', $data['meeting_date']);
		$this->db->bind('meeting_time', $data['meeting_time']);
		$this->db->bind('meeting_room', $data['meeting_room']);
		$this->db->bind('meeting_participants', $data['meeting_participants']);
		$this->db->bind('title', $data['title']);
		$this->db->bind('body', $data['body']);
		$this->db->bind('status', $data['status']);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function delete($id) {
		$query = "DELETE FROM minutes_of_meetings WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}
}
