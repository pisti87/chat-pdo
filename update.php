<?php
require 'core/init.php';
if (isset($_SESSION['user'])) {
	$stored_user = $_SESSION['user'];
} else header("Location: ./");
header('application/json');
$msg_id = trim($_POST['msg_id']);
$type = $_POST['type'];
$msg = "This message had deleted!";
$data['status'] = 'failed';
if ($type == "delete") {
	try {
		$res = $messages->delete($stored_user['user_id'], $stored_user['username'], $msg_id, 0);
		$data = array(
			'status'	=> $res
		);
	} catch (PDOException $e) {
		$data['status'] = 'failed';
	}
	echo json_encode($data);
}
if ($type == 'update') {
	try {
		$msg = $_POST['msg'];
		$time = time();
		$res = $messages->update($stored_user['user_id'], $stored_user['username'], $msg_id, $msg, 2);
		$data = array(
			'status'	=> $res
		);
	} catch (PDOException $e) {
		$data['status'] = 'failed';
	}
	echo json_encode($data);
}