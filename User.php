<?php
include_once __DIR__ . '/constants.php';

class User {
	public $username;
	public $email;
	public $name;
	public $date_of_birth;
	public $error = false;

	public function __construct($username, $password)
	{
		// connettersi al db
		$conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

		// cercare l'utente con username e password nel database
		$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
		$stmt->bind_param('s', $username);
		$stmt->execute();

		$results = $stmt->get_result();

		// restituire l'utente se tutto coincide oppure false
		if ($results && $results->num_rows == 1) {
			while ($row = $results->fetch_assoc()) {
				if (password_verify($password, $row['password'])) {
					$this->username = $row['username'];
					$this->email = $row['email'];
					$this->name = $row['name'];
					$this->date_of_birth = $row['date_of_birth'];
				} else {
					$this->error = 'Password sbagliata';
				}
			}
		} elseif ($results) {
			$this->error = 'Utente non trovato';
		} else {
			$this->error = 'Database error';
		}
	}
}
