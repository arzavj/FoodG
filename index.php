<html>
	<head>
		<?php
		include("head.php");
		?>
	</head>
	<body>


<!-- Handles the Resizing of the fridgeview -->	
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/jquery.dimensions.js"></script>
<script type="text/javascript">
	$(document).ready(function() { 
		var $winheight = $(window).height();
		$("img.source-image").attr({
			height: $winheight
		});
		$(window).bind("resize", function(){ 
			var $winheight = $(window).height();
			$("img.source-image").attr({
				height: $winheight
			});
		 });
	}); 
</script>
	
	
	
	<!-- Start of first page: #one -->
<div data-role="page" id="Home">
	<div data-role="header">
	
		<h1>Food Gatherer</h1>
	</div><!-- /header -->
	<div data-role="content">
		<img  src="images/fridgeHome.png" class="source-image" usemap ="#fridgeMap" />
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
	</div><!-- /header -->

	<div data-role="content">
		<!-- <div style="position: relative; left: 50%; top: 0;"> -->	
			<img src="images/fridgeView.png" class="source-image" />	
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
	</div><!-- /header -->

	<div data-role="content">	
		<img src="images/fridgeView.png" class="source-image" />
	</div><!-- /content -->
	<?php
		include("footer.php");
		?>

</div><!-- /page three -->


		
	</body>
</html>
