<html>
	<head>
		<?php
		include("head.php");
		?>
	</head>
	<body>
		<div data-role="page" id="mycart" data-add-back-btn="true">
			<div data-role="header">
				<a href="index.php" data-icon="home">Home</a>
				<h1>My Cart</h1>
				<a href="logout.php" data-role="button" class="ui-btn-right">Logout</a>
			</div>
			<div data-role="content">
				<form action="addToFridge.php" id="addToFridge" method="post">
					<input type="submit" data-theme="b" name="btnS" value="Add All To Fridge" />
				</form>
				<?php
					include("helperFunctions.php");
					if (get_magic_quotes_gpc() == true) {
			 			foreach($_COOKIE as $key => $value) {
			   				$_COOKIE[$key] = stripslashes($value);
			  			}
					}

					$cartArray = $_COOKIE["cart"];
					$cartArray = unserialize($cartArray);
					if(!is_null($_COOKIE["cart"]) && $_COOKIE["shop-cart-mode"]=="true")
					{
						foreach ($cartArray as $map)
						{
							if(isset($map))
							{
								$item = mysql_fetch_assoc(mysql_query(sprintf("SELECT * from foods WHERE id = %s", $map["food_id"])));
								echo "<div>\n";
								$link = sprintf("<a href='description.php?food=%s&update=1'>", $item['id']);
								echo $link;
								echo "<p>".$item['food'];
								$image = sprintf("<img src= %s class = %s />", $item['image_url'],'thumb' );
								echo $image."</a> Quantity: ".$map["quantity"].getQuantityName($map["quantity_type_id"])."</p>\n";
								echo "</div>\n";
								//echo "<p>".print_r($map)."</p>";
							}
						}
					}
				?>
			</div>
			<?php
				include("footer.php");
			?>
	</body>
</html>
