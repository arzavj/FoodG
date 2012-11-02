<?php
include("config.php");
$user = $_POST["username"];
$query = "SELECT password FROM users where username='$user'";
$result = mysql_query($query);

// This section is partly based on http://stackoverflow.com/questions/5285388/mysql-check-if-username-and-password-matches-in-database
if (mysql_num_rows($result) != 0) 
{
	$row = mysql_fetch_assoc($result);
	$password = crypt($_POST["password"], $user);
	if ($password == $row["password"]) 
	{
		setcookie("username",$user,time() + (86400 * 2)); // 86400 = 1 day
		header("Location: index.php");
		//echo "<p>".$_COOKIE["username"]."</p>";
		?>
		<script type="text/javascript">
			// Save the username in local storage. That way you
			// can access it later even if the user closes the app.
			//localStorage.setItem('username', '<?=$_POST["username"]?>');
			//console.log("User is now logged in.");
			//window.location = "index.php";
		</script>
		<?php
	} 
	else 
	{

			//alert("Login Failed");
			header("Location: index.php");

		//echo "<p>There seems to have been an error.</p>";
		//echo "<p>Actual password: ".$row["password"]." Typed: ".$password."</p>";
	}
} 
else 
{
	//echo "<p>There seems to have been an error.</p>";
	//echo "<p>".mysql_num_rows($result)."</p>";
}

?>

