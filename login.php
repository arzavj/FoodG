<?php
include("config.php");
$user = $_POST["username"];
$query = "SELECT id, password FROM users where username='$user'";
$result = mysql_query($query);

// This section is partly based on http://stackoverflow.com/questions/5285388/mysql-check-if-username-and-password-matches-in-database
if (!is_null($user)){
	if (mysql_num_rows($result) != 0) 
	{
		$row = mysql_fetch_assoc($result);
		$password = crypt($_POST["password"], $user);
		if ($password == $row["password"]) 
		{
			setcookie("user-id",$row["id"],time() + (86400 * 2)); // 86400 = 1 day
			?>
			<html>
			<body>
			<script type="text/javascript">
				window.location = "index.php";
			</script>
			</body>
			</html>
			<?php
		} 
		else 
		{
			$error = "<p>Either your username or password is incorrect.</p>";
			include "loginForm.php";
		}
	} 
	else 
	{
		$error = "<p>Either your username or password is incorrect.</p>";
		include "loginForm.php";
	}
} else{
	include "loginForm.php";
}
?>