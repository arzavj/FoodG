<head>
	<?php
		$loggingIn = 1;
		include "head.php";
	?>
</head>
<body>
<div data-role="page" id="loginpage">
	<div data-role="content">
		<?php
			echo "<h3>".$error."</h3>";
		?>
			<div><img src="images/logo-text.png" style="height: 15%; width: auto; display: block; margin-left:auto; margin-right:auto;"/></div> 

		<div class="wrapper">
			<form action="login.php" method="post" name="login-form" class="login-form">
				<div class="header">
					
					<h1>Login</h1>
					<span> Login to start keeping track of your food and prevent waste! </span>
				</div>  
				<div class="content">
					
						
						<input type="text" autocapitalize="off" name="username" class="input username" placeholder="Username">
						<div class="user-icon"></div>
						
						<input type="password" name="password" class="input password" placeholder="Password">
						<div class="pass-icon"></div>	
						
						<div class="footer">
							<input type="submit" value="Login" />
					</form>
						<a href="register.php" name="submit" value="Register" data-role="button">Register</a>
						</div>
				</div>
			</div>
			
		</div><!-- /content -->
</div><!-- /login page -->
</body>