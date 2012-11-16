<?php
	include "config.php";
?>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="viewport" content="width=device-width, user-scalable=no" />
<title>FoodG</title>

<?php
	if($_COOKIE["user-id"] == "" && is_null($loggingIn))
	{
?>
		<script type="text/javascript">
			window.location="login.php";
		</script>
<?php
	}
?>