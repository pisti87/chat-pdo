<?php
class Message {

	private $db;

	public function __construct($database) {

		$this->db = $database;
	}

	public function post($user_id, $user, $msg){
	
		$time 		= time();
		$ip 		= $_SERVER['REMOTE_ADDR'];
	 
		$query 	= $this->db->prepare("INSERT INTO `messages` (`user_id`, `username`, `message`, `ip`, `time`, `update_time`, `is_actived`) VALUES (?, ?, ?, ?, ?, ?, ?) ");
	 
		$query->bindValue(1, $user_id);
		$query->bindValue(2, $user);
		$query->bindValue(3, $msg);
		$query->bindValue(4, $ip);
		$query->bindValue(5, $time);
		$query->bindValue(6, $time);
		$query->bindValue(7, 1);
		try{
			$query->execute();
	 	}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function get_msg($message_id = 0) {

			$query = $this->db->prepare("SELECT * FROM `messages` WHERE `message_id` > ?");
			$query->bindValue(1, $message_id);
			try {
				$data = array();
				$query->execute();
				while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
					$row['message'] = htmlentities($row['message']);
					$data[] = $row;
				}
				return $data;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
	}

	public function get_msg_by_id($message_id = 0) {

			$query = $this->db->prepare("SELECT * FROM `messages` WHERE `message_id` = ?");
			$query->bindValue(1, $message_id);
			try {
				$data = array();
				$query->execute();
				$row = $query->fetch();
				$row['message'] = htmlentities($row['message']);
				$data[] = $row;
				
				return $data;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
	}

	public function update($user_id, $user, $msg_id, $msg, $is_actived){
		
		$r = $this->get_msg_by_id($msg_id);
		if ((count($r[0]) > 0) && ($r[0]['user_id'] == $user_id)) {
			$ip = $_SERVER['REMOTE_ADDR'];
			$update_time = time();
			$query 	= $this->db->prepare("UPDATE `messages` SET `message`=?, `ip`=?, `update_time`=?, `is_actived`=? WHERE `message_id` = ?");
			$query->bindValue(1, $msg);
			$query->bindValue(2, $ip);
			$query->bindValue(3, $update_time);
			$query->bindValue(4, intval($is_actived));
			$query->bindValue(5, $msg_id);
			try{
				$query->execute();
				return 'success';
		 	}catch(PDOException $e){
		 		return 'failed';
				die($e->getMessage());
			}			
		}
	}

	public function delete($user_id, $user, $msg_id, $is_actived){
		
		$r = $this->get_msg_by_id($msg_id);
		if ((count($r[0]) > 0) && ($r[0]['user_id'] == $user_id)) {
			$ip = $_SERVER['REMOTE_ADDR'];
			$update_time = time();
			$query 	= $this->db->prepare("UPDATE `messages` SET `ip`=?, `update_time`=?, `is_actived`=? WHERE `message_id` = ?");			
			$query->bindValue(1, $ip);
			$query->bindValue(2, $update_time);
			$query->bindValue(3, intval($is_actived));
			$query->bindValue(4, $msg_id);
			try{
				$query->execute();
				return 'success';
		 	}catch(PDOException $e){
		 		return 'failed';
				die($e->getMessage());
			}			
		}
	}

	public function get_deleted() {

		$query = $this->db->prepare("SELECT * FROM `messages` WHERE `time` = 0");
		try {
			$data = array();
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$row['message'] = htmlentities($row['message']);
				$data[] = $row;
			}
			return $data;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public function get_updated() {

		$query = $this->db->prepare("SELECT * FROM `messages` WHERE `is_actived`=2 OR `is_actived`=0");
		try {
			$data = array();
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$row['message'] = htmlentities($row['message']);
				$data[] = $row;
			}
			return $data;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
}
}