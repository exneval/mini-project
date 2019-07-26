<?php

include_once './cores/db/Database.php';

class Disburse {
	private $database;

	public function __construct() {
		$this->database = new Database();
	}

	public function sqlInsert($data) {
		$query = 'INSERT INTO logs VALUES (:id, :amount, :status, :timestamp, :bank_code, :account_number, :beneficiary_name, :remark, :receipt, :time_served, :fee)';
		$sql = $this->database;
		$sql->stmtPrepare($query);
		foreach ($data as $key => $value) {
			$sql->stmtBind($key, $value);
		}
		if ($sql->stmtExecute()) {
			return true;
		}
		return false;
	}

	public function sqlUpdate($data) {
		$query = 'UPDATE logs SET status=:status, receipt=:receipt, time_served=:time_served WHERE id=:id';
		$sql = $this->database;
		$sql->stmtPrepare($query);
		$sql->stmtBind('status', $data['status']);
		$sql->stmtBind('receipt', $data['receipt']);
		$sql->stmtBind('time_served', $data['time_served']);
		$sql->stmtBind('id', $data['id']);
		$sql->stmtExecute();
		if ($sql->stmtRowCount() == 1) {
			return true;
		}
		return false;
	}
}

?>