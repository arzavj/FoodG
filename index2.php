<html>
	<head>
		<?php
		include("head.php");
		?>
	</head>
	<body>
		
<!-- Main view -->
<div data-role="page" id="home" data-add-back-btn="true">
	<div data-role="header">
		<!-- <a href="#Home" data-icon="back">Back</a> -->
		<a href="myCart.php" class="ui-btn-left" id="my-cart-link" data-icon="custom" data-iconpos="right" data-role="button">My Cart</a>
		<h1>My Fridge</h1>
		<a href="logout.php" data-role="button" class="ui-btn-right">Logout</a>
		<script>
		$(document).ready(function(){
			changeCategories();

		});
		
		function changeCategories(){
			$.post("ajaxCategory2.php", {catID:$("#categories").val()}, function(data) {
    			var sugList = $("#food-content");
				sugList.html(data);
			});
		}	

		</script>
	</div><!-- /header -->

	<div data-role="content">
		<script src="//cdn.optimizely.com/js/141265170.js"></script>
				<?php 
			$checkNew = sprintf("SELECT *, foods.id AS fID from ((user_foods inner join foods ON foods.id = user_foods.food_id) 
			inner join quantity_types ON quantity_types.id = user_foods.quantity_type_id) 
			inner join user_storages ON user_storages.id = user_foods.user_storage_id 
			WHERE user_storages.user_id = %s", $_COOKIE['user-id']);
			if (mysql_num_rows(mysql_query($checkNew)) == 0):
		?>
		<script>
			$(document).unbind('pageshow');
			$(document).bind('pageshow', function(event){
				$("#popupPanel").popup({history: false});

				$("#popupPanel").on({
					popupbeforeposition: function() {
					var h = $( window ).height();
					var w = $( window ).width();

					$( "#popupPanel" ).css( "height", h );
					$( "#popupPanel" ).css( "width", w );


					$( "#myArrow" ).css( "top", h - 125);
					$( "#myArrow" ).css( "left",  w/10 );
				}
				});

				$("#popupPanel").popup( "open" );

			});
		</script>

		<style type="text/css">
			#popupPanel-popup {
				right: 0 !important;
				left: auto !important;
				}
				#popupPanel {
				width: 200px;
				border: 1px solid #000;
				border-right: none;
				background: rgba(0,0,0,.5);
				margin: -1px 0;
				}
				#popupPanel .ui-btn {
				margin: 2em 15px;
				}
				#helper {
				position:absolute;
				color:#fff;
				top:70px;
				left:20px;
				}
				.close {
				position:absolute;
				left:200px;
				top:300px !important;
				}
		</style>

		<div data-role="popup" id="popupPanel" data-corners="false" data-theme="none">
			<img src="images/arrow.png" style="-webkit-transform:rotate(180deg);position:absolute;top:10px;" id="myArrow"/>
				<div id="helper">
					<p>Start by adding an item</p>
				</div>
			<a href="#" class="close" data-rel="back" data-theme="a" data-role="button">Close me</a>
		</div>	

		<?php endif; ?>
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
			<option value="0">All Categories</option>
			<?php while ($row = mysql_fetch_array($categories)){ ?>
				<option value="<?= $row["id"]?>" ><?= $row["category"] ?> </option>
			<?php } ?>
		</select>


		


		<div id="food-content"></div>
		
		


		<h4> Space Used : <?php echo " ".round($percentUsed)."%"  ?></h4>
		<meter value="<?= $percentUsed?>" min= "0" max="100" low="20" high="75"></meter>
		

		
		
		
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
