<?php
class db
{
	private $host = "198.71.49.185";
	private $user = "client";
	private $pass = "password";
	private $dbName = "chat_app";

	public function connect() {
		try {
			$conn = new PDO('mysql:host='.$this.host.'; dbname='.$this.dbName, $this.user, $this.pass);
			return $conn;
		}
		catch (PDOException $e) {
			echo 'Error: '.$e->getMessage();
		}
	}
	
}
?>