<!DOCTYPE html> 
<html>
	<head>
	<?php
		$loggingIn = 1;
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
						$insert = sprintf("INSERT INTO user_storages (user_id, storage_id, max_volume) VALUES (%s, %s, %s);", $uID["curr"], $row["id"], $_POST['volume']);
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
				<a data-rel="back" data-icon="back">Back</a>
				<h1>Register</h1>

			</div><!-- /header -->

			<div data-role="content">
				<?php
					echo $error;
				?>

				<?php 
					if ($test){	
				?>
					<script>
						document.cookie =  'user-id=<?php echo $uID["curr"] ?>;'
						window.location="index.php";
					</script>
				<?php
					}
				?>

				<form action="register.php" method="POST" id="reg">
					<input type="text" name="username" id="user" placeholder="Username" >
					<input type="password" name="password" id="pass" placeholder="Password">
					<input type="password" name="passwordConfirm" id="passConfirm" placeholder="Password Confirmation">
					<label for="Space Dimensions" style="font-weight:bold;">Fridge Dimensions (cubic feet): </label>
					<input type="range" name="volume" value="4.6" min="1.3"  max="33.3" data-highlight="true"/>
        			<input type="submit" value="Register">
				</form>	
			</div><!-- /content -->
		</div><!-- /page -->
	</body>
</html>
