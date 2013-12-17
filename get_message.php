<?php
require 'core/init.php';
if (isset($_SESSION['user'])) {
	$stored_user = $_SESSION['user'];
} else header("Location: ./");
header('application/json');
$type = $_POST['type'];
if ($type == 'add') {
	$id = intval($_POST['id']);
	$data['status'] = 'no';
	$records = $messages->get_msg($id);
	if (count($records) > 0) {
		$data['status'] = 'refresh';
		foreach ($records as $record) {
			$record['update_time'] = date("d/m H:i", $record['update_time']);
			if ($stored_user['user_id'] == $record['user_id'])
				$record['own'] = 1;
			else $record['own'] = 0;
			$data['data'][] = $record;
			$last_id = $record['message_id'];
		}
		$data['last_id'] = $last_id;
	}
	echo json_encode($data);
} else if ($type == 'delete') {
	try {
		$records = $messages->get_deleted();
		
		if (count($records) > 0) {
			foreach ($records as $record) {
				$record['update_time'] = '1';
				$record['own'] = 0;
				$data['data'][] = $record;
				$msg_id = $record['message_id'];
				$msg = $record['message'];
				$time = time();
				$res = $messages->update($stored_user['user_id'], $stored_user['username'], $msg_id, $msg, '0', '1');
			}
			$data['status'] = 'success';
		}
	} catch (PDOException $e) {
		$data['status'] = 'failed';
	}
	echo json_encode($data);
} else if ($type == 'update') {
	try {
		$records = $messages->get_updated();

		if (count($records) > 0) {
			foreach ($records as $record) {
				$record['update_time'] = date("d/m H:i", $record['update_time']);
				if ($stored_user['user_id'] == $record['user_id'])
					$record['own'] = 1;
				else $record['own'] = 0;
				$data['data'][] = $record;
				$msg_id = $record['message_id'];
				$msg = $record['message'];
				$time = time();
				if ($record['is_actived'] == 2)
					$res = $messages->update($stored_user['user_id'], $stored_user['username'], $msg_id, $msg, 1);
			}
			$data['status'] = 'success';
		}
	} catch (PDOException $e) {
		$data['status'] = 'failed';
	}
	echo json_encode($data);
}