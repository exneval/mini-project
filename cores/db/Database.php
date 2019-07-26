<?php

include_once './cores/db/config.php';

class Database {
	private $host = db_hostname;
	private $user = db_username;
	private $pass = db_password;
	private $db = db_database;
	private $charset = db_charset;

	private $pdo;
	private $stmt;

	public function __construct() {
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=' . $this->charset;
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		try {
			$this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), (int)$e->getCode());
		}
	}

	public function stmtPrepare($query) {
		$this->stmt = $this->pdo->prepare($query);
	}

	public function stmtBind($parameter, $value) {
		$this->stmt->bindValue($parameter, $value);
	}

	public function stmtExecute() {
		return $this->stmt->execute();
	}

	public function stmtRowCount() {
		return $this->stmt->rowCount();
	}
}

?>
