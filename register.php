<?php
require 'core/init.php';
if (isset($_SESSION['user']))
	header("Location: home.php");
if (isset($_POST['submit'])) {
	if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
		$errors[] = 'All fields are required!';
	} else {
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$email = $_POST['email'];
		if ($users->check_user_exists($user))
			$errors[] = 'This user not available!';
		if ($users->check_email_exists($email))
			$errors[] = 'This email not available!';
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			$errors[] = 'Email invalid!';
	}

	if (empty($errors) === true) {
		$user = htmlentities($user);
		$email = htmlentities($email);
		$users->register($user, $pass, $email);
		$errors[] = 'Register successfully!';
		header( "refresh:2; url=./login.php" );
	}
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css" >
	<title>Register</title>
</head>
<body>	
	<div id="container">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="register.php">Register</a></li>
			<li><a href="login.php">Login</a></li>
		</ul>
		<h1>Register</h1>
 
		<form name="frm_register" method="post" action="">
			<h4>Username:</h4>
			<input type="text" name="username" value="<?php echo @$_POST['username']; ?>" />
			<h4>Password:</h4>
			<input type="password" name="password" value="<?php echo @$_POST['password']; ?>" />
			<h4>Email:</h4>
			<input type="text" name="email" value="<?php echo @$_POST['email']; ?>" />	
			<br>
			<input type="submit" name="submit" />
		</form>
 
		<?php
		if(empty($errors) === false){
			echo '<p>' . implode('</p><p>', $errors) . '</p>';
		}
 
		?>
 
	</div>
</body>
</html>