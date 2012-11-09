<html>
	<head>
		<?php
		include("head.php");
		?>
	</head>
	<body>
		<div data-role="page" id="mycart" data-add-back-btn="true">
			<div data-role="header">
				<h1>My Cart</h1>
			</div>
			<div data-role="content">
				<?php
					echo $_COOKIE["shop-cart-mode"];
				?>
			</div>
	</body>
</html>
