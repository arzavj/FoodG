<html>
	<head>
		<?php
		include("head.php");
		?>
	</head>
	<body>
	
	
	<!-- Start of first page: #one -->
<div data-role="page" id="Home">
	<div data-role="header">
	
		<h1>Food Gatherer</h1>
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
