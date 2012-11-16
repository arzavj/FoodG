<head>
	<?php
		$loggingIn = 1;
		include "head.php";
	?>
</head>
<div data-role="page">
	<script src="//cdn.optimizely.com/js/141265170.js"></script>
	<script src="//cdn.optimizely.com/js/12670182.js"></script>
	<div data-role="header">
		<h1>Food Gatherer</h1>
	</div><!-- /header -->

	<div data-role="content">
		<?php
			echo $error;
		?>
		<form action="login.php" method="post">
			<label for="username">Username:</label>
			<input type="text" autocapitalize="off" name="username">
			<label for="password">Password:</label>
			<input type="password" name="password">
			<input type="submit" value="Login">
		</form>
		<a href="register.php">Click here to register</a>
	</div><!-- /content -->
</div><!-- /login page -->
