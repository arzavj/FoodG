<?php
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
				echo $image."</a></p>\n";
				echo "</div>\n";
			}
		}
	}
?>