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
					
					function printEmptyCart()
					{
						echo "<p> Your cart is empty!</p>";
						?>
							<script>
								$(function(){
									$("input[name='btnS']").button();
									$("input[name='btnS']").button('disable');
									$("input[name='btnS']").button('refresh');
								});
							</script>
						<?php
					}
					$cartArray = $_COOKIE["cart"];
					if(is_null($cartArray))
						printEmptyCart();
					else
					{
						$cartArray = array_filter(unserialize($cartArray)); //filter out nulls
						if(empty($cartArray))
							printEmptyCart();
						else
						{
							echo "<ul data-role='listview'>";
							foreach ($cartArray as $map)
							{
								if(isset($map))
								{
									$item = mysql_fetch_assoc(mysql_query(sprintf("SELECT * from foods WHERE id = %s", $map["food_id"])));
									echo "<li>\n";
									$link = sprintf("<a href='description.php?food=%s&update=1&shop=1'>", $item['id']);
									$image = sprintf("<img src= %s />", $item['image_url']);
									echo $link.$image."<h3>".$item['food']."</h3>";
									//echo "<span class='ui-li-count'>".$map["quantity"].getQuantityName($map["quantity_type_id"])."</span>";
									echo "<p>".$map["quantity"].getQuantityName($map["quantity_type_id"])."</p>";
									echo "</a> ";
									echo "</li>\n";
									//echo "<p>".print_r($map)."</p>";
								}
							}
							echo "</ul>";
						}
					}
				?>
			</div>
			<?php
				include("footer.php");
			?>
	</body>
</html>
