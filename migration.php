<?php

include_once './cores/db/config.php';

try {
	$dbConn = new PDO('mysql:host=' . db_hostname, db_username, db_password);
	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = 'CREATE DATABASE IF NOT EXISTS ' . db_database;
	$dbConn->exec($query);
} catch (PDOException $e) {
    echo $e->getMessage();
}

$dbConn = NULL;

try {
	$dbConn = new PDO('mysql:host=' . db_hostname . ';dbname=' . db_database, db_username, db_password);
	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$query = 'CREATE TABLE IF NOT EXISTS `logs` (
		`id` bigint(20) unsigned NOT NULL,
		`amount` bigint(20) unsigned NOT NULL,
		`status` varchar(50) COLLATE utf8mb4_bin NOT NULL,
		`timestamp` datetime NOT NULL,
		`bank_code` varchar(50) COLLATE utf8mb4_bin NOT NULL,
		`account_number` bigint(20) unsigned NOT NULL,
		`beneficiary_name` varchar(50) COLLATE utf8mb4_bin NOT NULL,
		`remark` varchar(50) COLLATE utf8mb4_bin NOT NULL,
		`receipt` text COLLATE utf8mb4_bin,
		`time_served` datetime NOT NULL,
		`fee` bigint(20) unsigned NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;';
	$dbConn->exec($query);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>
