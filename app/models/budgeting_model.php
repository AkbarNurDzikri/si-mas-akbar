<?php

class Budgeting_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getBadgets() {
		$this->db->query("SELECT eb.*, c.username AS creator, ed.username AS editor, ev.event_name, ev.event_date, ev.event_location FROM event_budgeting AS eb INNER JOIN users AS c ON c.id = eb.created_by LEFT JOIN users AS ed ON ed.id = eb.updated_by INNER JOIN events AS ev ON ev.id = eb.event_id GROUP BY eb.event_id ORDER BY ev.event_name ASC");
		return $this->db->resultSet();
	}

	// Prepare First Multiple Insert
	public function create($data, $eventId) {
		foreach($data['budget_name'] as $key => $val) {
			if($val == ''){
				continue;
			}

			$recap = [
				'event_id' => $eventId,
				'budget_name' => $data['budget_name'][$key],
				'budget_price' => $data['budget_price'][$key],
				'remarks' => $data['remarks'][$key],
			];

			$response[] = $this->runCreate($recap);
		}
		return $response;
	}
	// End Prepare First Multiple Insert

	// Execute Multiple Insert
	public function runCreate($data) {
		$query = "INSERT INTO event_budgeting VALUES ('', :event_id, :created_by, :updated_by, :budget_name, :budget_price, :remarks, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('event_id', $data['event_id']);
		$this->db->bind('created_by',  $_SESSION['userInfo']['id']);
		$this->db->bind('updated_by',  NULL);
		$this->db->bind('budget_name', $data['budget_name']);
		$this->db->bind('budget_price', $data['budget_price']);
		$this->db->bind('remarks', $data['remarks']);
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}
	// End Execute Multiple Insert

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
