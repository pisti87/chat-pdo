<?php
class User {

	private $db;

	public function __construct($database) {

		$this->db = $database;
	}

	public function check_user_exists($user) {

		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `username`=?");
		$query->bindValue(1, $user);
		try {
			$query->execute();
			$records = $query->fetchColumn();
			if ($records == 1)
				return true;
			return false;
		} catch (PDOException $ex) {
			die($ex->getMessage());
		}
	}

	public function check_email_exists($email) {

		$query = $this->db->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `email`=?");
		$query->bindValue(1, $email);
		try {
			$query->execute();
			$records = $query->fetchColumn();
			if ($records == 1)
				return true;
			return false;
		} catch (PDOException $ex) {
			die($ex->getMessage());
		}
	}

	public function register($username, $password, $email){
	
		$time 		= time();
		$ip 		= $_SERVER['REMOTE_ADDR'];
		$password   = sha1($password);
	 
		$query 	= $this->db->prepare("INSERT INTO `users` (`username`, `password`, `email`, `ip`, `time`) VALUES (?, ?, ?, ?, ?) ");
	 
		$query->bindValue(1, $username);
		$query->bindValue(2, $password);
		$query->bindValue(3, $email);
		$query->bindValue(4, $ip);
		$query->bindValue(5, $time);
	 
		try{
			$query->execute();
	 	}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function login($username, $password) {

		$query = $this->db->prepare("SELECT `username`, `password`, `user_id` FROM `users` WHERE `username` = ?");
		$query->bindValue(1, $username);
		
		try{
			
			$query->execute();
			$data 				= $query->fetch();
			$stored_password 	= $data['password'];
			$id 				= $data['id'];
			
			#hashing the supplied password and comparing it with the stored hashed password.
			if($stored_password === sha1($password)){
				return $data;
			}else{
				return false;	
			}
	 
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
}