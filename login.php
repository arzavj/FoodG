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
	<h1>Log in</h1>
	<a href="#" data-icon="check" id="logout" class="ui-btn-right">Logout</a>

	</div><!-- /header -->

	<div data-role="content">
	
	<form action="enter.php" method="post">
		<label for="user">Username:</label>
		<input type="text" name="username" id="user">
		<label for="pass">Password:</label>
		<input type="password" name="password" id="pass">
        	<input type="submit" value="Login">
	</form>

	<a href="register.php">Click here to register</a>
		
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>
