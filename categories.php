<html>
<head>
        <?php
                include 'head.php';
        ?>
</head>


<body>

<div data-role="page" id="fridgeview" data-add-back-btn="true">
	<script src="//cdn.optimizely.com/js/141265170.js"></script>
	<script type="text/javascript">
		$("#searchField").on("input", function(e) {
    		if ($("#searchField").val().length == 0){
    			$("#searchContent").hide();
    			$("#categories").show();
    		} else{
    			$("#searchContent").show();
    			$("#categories").hide();
    			$.post("ajaxSearch.php", {search:$("#searchField").val(), all:true}, function(data) {
    				var sugList = $("#suggestions");
					sugList.html(data);
					sugList.listview("refresh").trigger("create");
				});
    		}
    	});

	</script>
	<div data-role="header">
		<!-- <a data-rel="back" data-icon="back">Back</a> -->
		<h1>Categories</h1>
		<a href="logout.php" data-role="button" class="ui-btn-right">Logout</a>
	</div><!-- /header -->
	<div data-role="content">
		<input type="text" id="searchField" placeholder="Search">
		<div id="searchContent" style="display:none;">
			<ul id="suggestions" data-role="listview" data-inset="true"></ul>
		</div>
		<div id="categories">
			<div class="ui-grid-a">
				<?php
					$count = 0;
					$result = mysql_query("SELECT * from categories");
					while($row = mysql_fetch_array($result)){
						if ($count == 0){
							echo '<div class="ui-block-a">';
						} else {
							echo '<div class="ui-block-b">';
						}		
				?>
					<div class="dashboard-icon">
						<a href="list.php?cat_id=<?php echo $row["id"] ?>">
							<div><img src="<?php echo $row["image_url"]?>" /></div>
							<div class="category-name"><?php echo $row["category"] ?></div>
						</a>
					</div>
				<?php
					echo "</div>";
					$count = ($count + 1) % 2;  
					}
				?>

				<?php 
					if ($count == 0){
						echo '<div class="ui-block-a">';
					} else {
						echo '<div class="ui-block-b">';
					}
				?>

				<div class="dashboard-icon">
					<a href="newFood.php">
						<div><img src="images/other-icon.svg" /></div>
						<div class="category-name">Other Food</div>
					</a>
				</div>
			</div> <!-- end block -->
			</div> <!-- /grid -->
		</div> <!-- /categories -->
	</div><!-- /content -->
</div><!-- /End of Categories List Page -->


<!-- Plan to implement "Pop up lists" for selection of each first item -->

</body>

</html>
