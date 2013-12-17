<?php
require 'core/init.php';
if (isset($_SESSION['user']))
	header("Location: ./");
if (empty($_POST) === false) {
 
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	if (empty($username) === true || empty($password) === true) {
		$errors[] = 'All fields are required!';
	} else if ($users->check_user_exists($username) === false) {
		$errors[] = 'Username doesn\'t exists!';
	} else {
		$login = $users->login($username, $password);
		if ($login === false) {
			$errors[] = 'Username/Password is invalid!';
		}else {
 			$_SESSION['user'] =  $login;
			header('Location: ./');
			exit();
		}
	}
} 
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" >
	<title>Login</title>
</head>
<body>	
	<div id="container">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="register.php">Register</a></li>
			<li><a href="login.php">Login</a></li>
		</ul>
		<h1>Login</h1>
 
		
		<form method="post" action="">
			<h4>Username:</h4>
			<input type="text" name="username">
			<h4>Password:</h4>
			<input type="password" name="password">
			<br>
			<input type="submit" name="submit">
		</form>
		<?php if(empty($errors) === false){
 
			echo '<p>' . implode('</p><p>', $errors) . '</p>';			
		} 
		?>
	</div>
</body>
</html>