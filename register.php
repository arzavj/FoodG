<?php
	$error = NULL;
	if(!is_null($_POST['username'])){
		$query = sprintf('Select * from users WHERE username = %s', $_POST['username']);
		$result = mysql_query($query);
		if (mysql_num_rows($result) > 0){
			$error = "Username already taken. \n";
		}

		if ($_POST['password'] == $_POST['passwordConfirm']){
			if (is_null($error)){	
				$insert = sprintf('INSERT INTO users(username, password) VALUES ("%s", "%s")', $_POST['username'], $_POST['password']);
				mysql_query($insert);
				header( 'Location: index.html' );
			
			}
		} else {
			$error = $error +  "Passwords do not match.\n";
		}
	}
?>
<!DOCTYPE html> 
<html>

<head>
<?php 
	include "head.php";
?>
</head>  
<body> 

<div data-role="page">

	<div data-role="header">
	<h1>Register</h1>

	</div><!-- /header -->

	<div data-role="content">
	<form action="register.php" method="POST">
		<label for="user">Username:</label>
		<input type="text" name="username" id="user">
		<label for="pass">Password:</label>
		<input type="password" name="password" id="pass">
		<label for="passConfirm">Password Confirmation:</label>
		<input type="password" name="passwordConfirm" id="passConfirm">
        	<input type="submit" value="Register">
	</form>
		
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>
