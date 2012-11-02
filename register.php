<!DOCTYPE html> 
<html>
	<head>
	<?php
		include "head.php";
		$error = "";
		$test = 0;
		if(!is_null($_POST['username'])){
			$query = sprintf('SELECT * from users WHERE username = "%s"', $_POST['username']);
			$result = mysql_query($query);
			if (mysql_num_rows($result) > 0){
				$error = "Username already taken. \n";
			}

			if ($_POST['password'] == $_POST['passwordConfirm']){
				if ($error == ""){	
					$insert = sprintf("INSERT INTO users (username, password) VALUES (\"%s\", \"%s\");", $_POST['username'], crypt($_POST['password'], $_POST['username']));
					mysql_query($insert);
					$uID = mysql_fetch_array(mysql_query("Select MAX(id) AS curr from users;"));
					$result2 = mysql_query("SELECT id from storages");
					while($row = mysql_fetch_array($result2)){
						$insert = sprintf("INSERT INTO user_storages (user_id, storage_id, volume) VALUES (\"%s\", \"%s\", \"%s\");", $uID["curr"], $row["id"], $_POST['size']);
						mysql_query($insert);
					}
					
					$test = 1;	
				}
			} else {
				$error = $error."Passwords do not match.\n";
			}
		}
	?>

</head>  
<body> 



<div data-role="page">

	<div data-role="header">
	<h1>Register</h1>

	</div><!-- /header -->

	<div data-role="content">

	<?php
		echo $error;
	?>

	<?php 
		if ($test):
	?>
		<script>
			window.location="index.php";
		</script>
	<?php
	endif
?>

	<form action="register.php" method="POST">
		<label for="user">Username:</label>
		<input type="text" name="username" id="user">
		<label for="pass">Password:</label>
		<input type="password" name="password" id="pass">
		<label for="passConfirm">Password Confirmation:</label>
		<input type="password" name="passwordConfirm" id="passConfirm">
		<select name="size">
			<option value="10">Small</option>
			<option value="20">Medium</option>
			<option value="30">Large</option>
		</select>
        <input type="submit" value="Register">
	</form>
	<a href="index.php">Already Registered - Login</a>		
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>
