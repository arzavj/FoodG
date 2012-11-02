<html>
<head>
        <?php
                include 'head.php';
        ?>
</head>


<body>

<div data-role="page" id="fridgeview" data-add-back-btn="true">
	<div data-role="header">
		<a href="index.php" data-icon="back">Back</a>
			<h1>Categories</h1>
	</div><!-- /header -->
	<div data-role="content">
		<div class="ui-grid-a">
			<div class="ui-block-a">
				<div class="dashboard-icon">
					<a href="list.php" rel="external">
					<div><img src="images/fruit-icon.svg" /></div>
					<div class="category-name">Fruits</div>
					</a>
				</div>
			</div>
			<div class="ui-block-b">
				<div class="dashboard-icon">
					<a href="list.php" rel="external">
					<div><img src="images/meat-icon.svg" /></div>
					<div class="category-name">Meats</div>
					</a>
				</div>
			</div>
			<div class="ui-block-a">
				<div class="dashboard-icon">
					<a href="list.php" rel="external">
					<div><img src="images/vegetable-icon.svg" /></div>
					<div class="category-name">Vegetables</div>
					</a>
				</div>
			</div>	
			<div class="ui-block-b">
				<div class="dashboard-icon">
					<a href="list.php" rel="external">
					<div><img src="images/dairy-icon.svg" /></div>
					<div class="category-name">Dairy</div>
					</a>
				</div>
			</div>	
			<div class="ui-block-a">
				<div class="dashboard-icon">
					<a href="list.php" rel="external">
					<div><img src="images/fish-icon.svg" /></div>
					<div class="category-name">Fish & Seafood</div>
					</a>
				</div>
			</div>	
			<div class="ui-block-b">
				<div class="dashboard-icon">
					<a href="list.php" rel="external">
					<div><img src="images/liquid-icon.svg" /></div>
					<div class="category-name">Liquids</div>
					</a>
				</div>
			</div>	
			<div class="ui-block-a">
				<div class="dashboard-icon">
					<a href="list.php" rel="external">
					<div><img src="images/grain-icon.svg" /></div>
					<div class="category-name">Grains & Cereals</div>
					</a>
				</div>
			</div>	
			<div class="ui-block-b">
				<div class="dashboard-icon">
					<a href="list.php" rel="external">
					<div><img src="images/other-icon.svg" /></div>
					<div class="category-name">Other</div>
					</a>
				</div>
			</div>	
			
		</div>
		<!-- <ul data-role="listview">
			<li><a href="#">Meats</a></li>
			<li><a href="#">Vegetables</a></li>
			<li><a href="list.php" rel="external">Fruits</a></li>
			<li><a href="#">Dairy</a></li>
			<li><a href="#">Fish & Seafood</a></li>
			<li><a href="#">Beverages</a></li>
			<li><a href="#">Leftovers</a></li>
			<li><a href="#">Other Foods</a></li>
		</ul> -->
	</div><!-- /content -->
</div><!-- /End of Categories List Page -->


<!-- Plan to implement "Pop up lists" for selection of each first item -->

</body>

</html>
