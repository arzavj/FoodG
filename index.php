<html>
	<head>
		<?php
		include("head.php");
		?>
	</head>
	<body>
	
<?php
	echo "<p>".$_COOKIE["username"]."</p>";
	if($_COOKIE["username"]!="")
	{
?>
		<script type="text/javascript">
			window.location="#Home";
		</script>
<?php
	}
	else
	{
?>
		<script type="text/javascript">
			console.log("No cookie");
		</script>
<?php
	}	
?>
	<!-- Login Page -->
	<div data-role="page" id="Login">
		<div data-role="header">

			<h1>Food Gatherer</h1>
		</div><!-- /header -->
		<div data-role="content">
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


	<!-- Start of first page: #one -->
	<div data-role="page" id="Home">
		<div data-role="header">
			<h1>Food Gatherer</h1>
			<a href="#" id="logout" data-icon="check" data-role="button" >Logout</a>
		</div><!-- /header -->
		<div data-role="content">
			<div style="position: absolute; text-align: center; width: 100%;">
				<img src="images/fridgeHome.png" usemap ="#fridgeMap" id="mainFridge"/>
			</div>
			<map id ="fridgeMap"name="fridgeMap">
				<area shape="rect" coords="0,0,103,452" href="#freezerview" alt="" title=""    />
				<area shape="rect" coords="104,0,237,452" href="#fridgeview" alt="" title=""    />

			</map>
		</div><!-- /content -->
		<?php
			include("footer.php");
		?>
	</div><!-- /page one -->

		
		<!-- Start of second page: #fridgeview -->
<div data-role="page" id="fridgeview" data-add-back-btn="true">

	<div data-role="header">
		<a href="#Home" data-icon="back">Back</a>
		<h1>MyFridge</h1>
		<a href="#" data-role="button" >Logout</a>
	</div><!-- /header -->

	<div data-role="content">
		<div style="position: relative; left: 50%; top: 0;">	
			<img src="images/fridgeView.png" class="displayView" />	
			<?
				if($_POST["name"] == "Apple"){
			?>

			<img src="images/apple.jpg" style="width: 25px; height: 25px; position: absolute; top: 240px; left: 0;" />

			<?php
			}
			?>
		</div>
	</div><!-- /content -->
	<?php
		include("footer.php");
	?>

</div><!-- /page two -->


<!-- Start of third page: #freezerview -->
<div data-role="page" id="freezerview" data-add-back-btn="true">

	<div data-role="header">
		<a href="#Home" data-icon="back">Back</a>
		<h1>MyFreezer</h1>
		<a href="#" data-icon="gear">Settings</a>
		<a href="#">Logout</a>
	</div><!-- /header -->

	<div data-role="content">
		<div style="position: relative; left: 50%; top: 0;">		
			<img src="images/fridgeView.png" class="displayView" />
		</div>
	</div><!-- /content -->
	<?php
		include("footer.php");
		?>

</div><!-- /page three -->


		
	</body>
</html>