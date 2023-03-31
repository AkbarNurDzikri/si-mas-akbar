<?php

class Users_model
{
	private $db;

	public function __construct() {
		$this->db = new Database;
	}

	public function getUsers() {
		$this->db->query("SELECT u.*, r.role_name FROM users AS u INNER JOIN roles AS r ON r.id = u.role_id ORDER BY u.username ASC");
		return $this->db->resultSet();
	}

	public function createUser($data) {
		$query = "INSERT INTO users VALUES ('', :role_id, :username, :email, :password, :created_at, :updated_at)";

		$this->db->query($query);
		$this->db->bind('role_id', $data['role_id']);
		$this->db->bind('username', $data['username']);
		$this->db->bind('email', $data['email']);
		$this->db->bind('password', password_hash($data['password'], PASSWORD_DEFAULT));
		$this->db->bind('created_at', date('Y-m-d H:i:s'));
		$this->db->bind('updated_at', NULL);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function getDataById($id) {
		$this->db->query("SELECT u.*, r.role_name FROM users AS u INNER JOIN roles AS r ON r.id = u.role_id WHERE u.id = :id");
		$this->db->bind('id', $id);
		return $this->db->single();
	}

	public function getDataByUsername($username) {
		$this->db->query("SELECT u.*, r.role_name FROM users AS u INNER JOIN roles AS r ON r.id = u.role_id WHERE username = :username");
		$this->db->bind('username', $username);
		return $this->db->single();
	}

	public function update($data) {
		$query = "UPDATE users SET
			username = :username,
			email = :email,
			password = :password,
			updated_at = :updated_at
		WHERE id = :id";

		$this->db->query($query);
		$this->db->bind('username', $data['username']);
		$this->db->bind('email', $data['email']);
		$this->db->bind('password', $data['password']);
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function delete($id) {
		$query = "DELETE FROM users WHERE id = :id";
		$this->db->query($query);
		$this->db->bind('id', $id);

		$this->db->execute();

		return $this->db->rowCount();
	}

	public function changeCredentials($data) {
		$query = "UPDATE users SET
			username = :username,
			email = :email,
			password = :password,
			updated_at = :updated_at
		WHERE id = :id";

		$this->db->query($query);
		$this->db->bind('username', $data['username']);
		$this->db->bind('email', $data['email']);
		$this->db->bind('password', password_hash($data['newPassword'], PASSWORD_DEFAULT));
		$this->db->bind('updated_at', date('Y-m-d H:i:s'));
		$this->db->bind('id', $data['id']);

		$this->db->execute();

		return $this->db->rowCount();
	}
}
