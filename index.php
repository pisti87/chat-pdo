<?php
require 'core/init.php';

if (isset($_SESSION['user'])) {
	$stored_user = $_SESSION['user'];
}
?>
<!doctype>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Chat system</title>
	<style type="text/css">
	</style>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/chat.js"></script>
</head>
<body onload="document.getElementById('conversation').scrollTop = document.getElementById('conversation').scrollHeight;">	
	<div id="container">
		<ul>
			<li><a href="index.php">Home</a></li>
			<?php if (isset($_SESSION['user'])) {?>
			<li><a href="#"><?php echo $_SESSION['user']['username']; ?></a></li>
			<li><a href="logout.php">Logout</a></li>
			<?php } else { ?>
			<li><a href="register.php">Register</a></li>
			<li><a href="login.php">Login</a></li>
			<?php } ?>
		</ul>
		<h1>Welcome to chat system!</h1>
		<?php if (isset($_SESSION['user'])) {?>
		<div class="chatbox">
			<div id="conversation">
				<?php
				$data = $messages->get_msg(0);
				foreach ($data as $record) {
					if ($record['is_actived'] != '0') {
					?>
					<div class="msg-record msg-record-<?php echo $record['message_id']; ?>" id="<?php echo $record['message_id']; ?>">
						<span class="user user-<?php echo $record['message_id']; ?>" id="<?php echo $record['message_id']; ?>"><?php echo $record['username']; ?></span>: 
						<span class="mes mes-<?php echo $record['message_id']; ?>" id="<?php echo $record['message_id']; ?>"><?php echo $record['message']; ?></span>
						<span class="time time-<?php echo $record['message_id']; ?>" id="<?php echo $record['message_id']; ?>"><?php echo date("d/m H:i", $record['update_time']); ?></span>
						
						<span class="edit edit-<?php echo $record['message_id']; ?>" id="<?php echo $record['message_id']; ?>"><?php if ($stored_user['username'] == $record['username']) echo 'edit'; ?></span>
						<span class="delete delete-<?php echo $record['message_id']; ?>" id="<?php echo $record['message_id']; ?>"><?php if ($stored_user['username'] == $record['username']) echo 'delete'; ?></span>

					</div>
					<?php
					}
				}
				
				?>
			</div>
			<input type="hidden" id="current_msg_id" value="<?php echo $record['message_id']; ?>">
			<div class="message">
				<form id="frm-msg" name="frm-msg" onsubmit="return false;">
					<input type="text" placeholder="enter your message" name="msg" id="msg">
					<input type="submit" value="Send" id="btn-send">
				</form>
			</div>
		</div>
		<?php } ?>
	</div>
</body>
</html>