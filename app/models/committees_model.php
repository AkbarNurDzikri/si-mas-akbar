<?php

class Committees_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getCommittees() {
		$this->db->query("SELECT ec.*, c.username AS creator, ed.username AS editor, ev.event_name, ev.event_date, ev.event_location FROM event_committees AS ec INNER JOIN users AS c ON c.id = ec.created_by LEFT JOIN users AS ed ON ed.id = ec.updated_by INNER JOIN events AS ev ON ev.id = ec.event_id GROUP BY ec.event_id ORDER BY ev.event_name ASC");
		return $this->db->resultSet();
	}

	// Prepare First Multiple Insert
	public function create($data, $eventId) {
		foreach($data['position'] as $key => $val) {
			if($val == ''){
				continue;
			}

			$recap = [
				'event_id' => $eventId,
				'person_name' => $data['person_name'][$key],
				'position' => $data['position'][$key],
				'main_duties_and_functions' => $data['main_duties_and_functions'][$key],
			];

			$response[] = $this->runCreate($recap);
		}
		return $response;
	}
	// End Prepare First Multiple Insert

	// Execute Multiple Insert
	public function runCreate($data) {
		$query = "INSERT INTO event_committees VALUES (NULL, :event_id, :created_by, :updated_by, :person_name, :position, :main_duties_and_functions, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('event_id', $data['event_id']);
		$this->db->bind('created_by',  $_SESSION['userInfo']['id']);
		$this->db->bind('updated_by',  NULL);
		$this->db->bind('person_name', $data['person_name']);
		$this->db->bind('position', $data['position']);
		$this->db->bind('main_duties_and_functions', $data['main_duties_and_functions']);
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}
	// End Execute Multiple Insert

	public function getDataById($eventId) {
		$this->db->query("SELECT ec.*, ev.event_name, ev.event_date, ev.event_time, ev.event_location, mom.title, mom.meeting_date, mom.meeting_time, mom.meeting_room, mom.meeting_participants FROM event_committees AS ec INNER JOIN events AS ev ON ev.id = ec.event_id INNER JOIN minutes_of_meetings AS mom ON mom.id = ev.ref_meeting WHERE ec.event_id = :id");

		$this->db->bind('id', $eventId);
		return $this->db->resultSet();
	}

	public function update($data) {
		$query = "UPDATE event_committees SET
				updated_by = :updated_by,
				person_name = :person_name,
				position = :position,
				main_duties_and_functions = :main_duties_and_functions,
				updated_at = :updated_at
		WHERE id = :id
		";

		$this->db->query($query);
		$this->db->bind('updated_by', $_SESSION['userInfo']['id']);
		$this->db->bind('person_name', $data['person_name']);
		$this->db->bind('position', $data['position']);
		$this->db->bind('main_duties_and_functions', $data['main_duties_and_functions']);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function delete($id) {
		$query = "DELETE FROM event_committees WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}
}
