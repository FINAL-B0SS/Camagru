<?php
//No error reporting as required by project PDF
error_reporting(0);
require_once 'database.php';
//Connect to database server
$dsn = "mysql:host=$DB_DSN";
$opt = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];
try {
	$dbConn = new PDO($dsn, $DB_USER, $DB_PASSWORD, $opt);
	//Create database
	$sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME;";
	$dbConn->exec($sql);
} catch (PDOException $e) {
	echo $e->getMessage()."<br />";
	die();
}

//Connect to database 
$dsn = "mysql:host=$DB_DSN;dbname=$DB_NAME;charset=$charset";
try {
	$dbConn = new PDO($dsn, $DB_USER, $DB_PASSWORD, $opt);
	//Create comments table
	$sql = "CREATE TABLE `comments` (
		`id` int(11) NOT NULL,
		`owner` varchar(256) NOT NULL,
		`image` varchar(256) NOT NULL,
		`comment` varchar(256) NOT NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$dbConn->exec($sql);
	//Create images table
	$sql = "CREATE TABLE `images` (
		`id` int(11) NOT NULL,
		`image` varchar(100) NOT NULL,
		`owner` varchar(256) NOT NULL,
		`likes` int(11) NOT NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$dbConn->exec($sql);
	//Create users table
	$sql = "CREATE TABLE `users` (
		`id` int(11) NOT NULL,
		`name` varchar(256) DEFAULT NULL,
		`password` varchar(256) DEFAULT NULL,
		`email` varchar(256) DEFAULT NULL,
		`notify` int(1) NOT NULL DEFAULT '1',
		`isEmailConfirmed` int(11) DEFAULT '0',
		`token` varchar(256) DEFAULT NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$dbConn->exec($sql);
} catch (PDOException $e) {
	echo $e->getMessage()."<br />";
	die();
}
 
echo "Setup Complete. Camagru is ready.<br />";
echo "<a href='http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/../'>Visit Camagru</a>";
//Collations affect how data is sorted and how strings are compared to each other.
//It is best to use character set utf8mb4 with the collation of utf8mb4_unicode_ci (utf8 only supports a small amount of UTF-8 code points and only supports the Basic Multilingual Plane. There are 16 other planes, each containing 65,536 characters. utf8mb4 supports all 17 planes.)
//ROW_FORMAT=DYNAMIC is reuired for indexes on VARCHAR(192) and larger
//https://stackoverflow.com/questions/367711/what-is-the-best-collation-to-use-for-mysql-with-php
//InnoDB should be the default storage enginge; It is a transaction-safe (ACID compliant) storage engine for MySQL that has commit, rollback, and crash-recovery capabilities to protect user data. InnoDB row-level locking (without escalation to coarser granularity locks) and Oracle-style consistent nonlocking reads increase multi-user concurrency and performance.
//https://stackoverflow.com/questions/3818759/what-is-innodb-and-myisam-in-mysql