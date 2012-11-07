<?php
	$loggingIn = 1;
	include "head.php";
?>
<div data-role="page">
	<div data-role="header">
		<h1>Food Gatherer</h1>
	</div><!-- /header -->

	<div data-role="content">
		<?php
			echo $error;
		?>
		<form action="login.php" method="post">
			<label for="username">Username:</label>
			<input type="text" name="username">
			<label for="password">Password:</label>
			<input type="password" name="password">
			<input type="submit" value="Login">
		</form>
		<a href="register.php">Click here to register</a>
	</div><!-- /content -->
</div><!-- /login page -->
