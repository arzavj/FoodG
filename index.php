<html>
	<head>
		<?php
		include("head.php");
		?>
		<script src="//cdn.optimizely.com/js/141265170.js"></script>
	</head>
	<body>
		
<!-- Main view -->
<div data-role="page" id="home" data-add-back-btn="true">
	<div data-role="header">
		<!-- <a href="#Home" data-icon="back">Back</a> -->
		<h1>My Fridge</h1>
		<a href="logout.php" data-role="button" class="ui-btn-right">Logout</a>
		<script>
		$(document).ready(function(){
			changeCategories();
			<?php
				if($_COOKIE["shop-cart-mode"]=="true")
				{
				?>
					$('#shop-cart').val('on').trigger('keyup');
				<?php
				}	
				else
				{
				?>
					$("#my-cart-link").hide();
				<?php
				}
			?>
			//$( "#accordion" ).accordion();
			$('#shop-cart').change(function() {
			    var myswitch = $(this);
			    var show     = myswitch[0].selectedIndex == 1 ? true:false;
			    $('#my-cart-link').toggle(show);
				$.post("shop-cart-mode.php", {"shop-cart-mode":show}, function(data) {});
			});
		});
		
		function changeCategories(){
			$.post("ajaxCategory.php", {catID:$("#categories").val()}, function(data) {
    			var sugList = $("#food-content");
				sugList.html(data);
			});
		}	

		</script>
	</div><!-- /header -->

	<div data-role="content">
		
		<?php
		include "config.php";

		$userName = sprintf("SELECT username, saved_points from users WHERE id = %s", $_COOKIE['user-id']);
		$userName = mysql_fetch_array(mysql_query($userName));
		//echo "Hello, <b>".$userName["username"]." (".$userName["saved_points"].")</b>. <br>";

//NOTE CHECK ON POINT SYSTEM!!!

		?>
		
		<!--
		<div data-role="fieldcontain">
			<label for="shop-cart">Shopping Cart Mode:</label>
			<select data-inline="true" name="shop-cart" id="shop-cart" data-role="slider">
				<option value="off">Off</option>
				<option value="on">On</option>
			</select>
		</div>

		
		<a href="myCart.php" id="my-cart-link" data-icon="arrow-r" data-iconpos="right" data-role="button">My Cart</a>
		
		-->
		<script type="text/javascript">
			$(window).load(function() {    

				var theWindow        = $(window),
				    $bg              = $("#bg"),
				    aspectRatio      = $bg.width() / $bg.height();
				    			    		
				function resizeBg() {
					
					if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
					    $bg
					    	.removeClass()
					    	.addClass('bgheight');
					} else {
					    $bg
					    	.removeClass()
					    	.addClass('bgwidth');
					}
								
				}
				                   			
				theWindow.resize(function() {
					resizeBg();
				}).trigger("resize");

			});
		</script>


		<?php
		$storequest= sprintf('SELECT id,max_volume,curr_volume FROM user_storages WHERE user_id = %s', $_COOKIE['user-id']);
		$storeLoc = mysql_query($storequest);
		$storageId = mysql_fetch_array($storeLoc);
		$percentUsed = ($storageId["curr_volume"]/$storageId["max_volume"])*100;

		//echo '<a href="search.php" data-role="button" data-icon="search">Search Your Fridge</a>';
		$categories = mysql_query("SELECT * from categories");
		?>

		<!--<img src="images/fridgeView.png" id="bg" alt="" /> -->



		<select id="categories" onchange="changeCategories();">
			<option value="0">All</option
			<?php while ($row = mysql_fetch_array($categories)){ ?>
				<option value="<?= $row["id"]?>" ><?= $row["category"] ?> </option>
			<?php } ?>
		</select>


		


		<div id="food-content"></div>
		
		



		<meter value="<?= $percentUsed?>" min= "0" max="100"></meter>
		
		
		
		
	</div><!-- /content -->
	<?php
		include("footer.php");
	?>

</div>




<!-- Start of third page: #freezerview -->
<!-- <div data-role="page" id="freezerview" data-add-back-btn="true">

	<div data-role="header">
		<a href="#Home" data-icon="back">Back</a>
		<h1>MyFreezer</h1>
		<a href="#" data-icon="gear">Settings</a>
		<a href="#" id="logout">Logout</a>
	</div>

	<div data-role="content">
		<div style="position: relative; left: 50%; top: 0;">		
			<img src="images/fridgeView.png" class="displayView" />
		</div>
	</div>
	<?php
		//include("footer.php");
		?>

</div> --><!-- /page three -->

		
	</body>
</html>
