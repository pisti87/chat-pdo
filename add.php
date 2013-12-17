<?php
require 'core/init.php';
if (isset($_SESSION['user'])) {
	$stored_user = $_SESSION['user'];
} else header("Location: ./");
header('application/json');
$msg = trim($_POST['msg']);
if ($msg != "") {
	$messages->post($stored_user['user_id'], $stored_user['username'], $msg, time());
	$data = array(
		'msg'	=> htmlentities($msg),
		'user'	=> $stored_user['username'],
		'user_id'	=> $stored_user['user_id']
		);
	echo json_encode($data);
}