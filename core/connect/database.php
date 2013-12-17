<?php
/*
class MyPDO extends PDO {

	public static $db = false;
	private $host = '192.168.33.11';
	private $user = 'root';
	private $pass = 'root';
	private $dbname = 'chat';

	function __construct() {
		
		if (self::$db === false)
			$this->connect();
	}

	private function connect() {

		try {
			self::$db = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
			self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $ex) {
			echo $ex->getMessage();
		}
	}
}
*/

$config = array(
	'host'		=> '192.168.33.11',
	'username'	=> 'root',
	'password'	=> 'root',
	'dbname' 	=> 'chat'
);
$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>