<head>
	<?php
		include 'head.php';
	?>
</head>
<body>
        <div data-role="header">
                <a data-rel="back" data-icon="back">Back</a>
                		<?php
                			$query1 = sprintf("SELECT category from categories WHERE id = %s LIMIT 1", $_GET["cat_id"]);
							$result1 = mysql_query($query1);
							$row1 = mysql_fetch_array($result1);
                		?>
                        <h1><?php echo $row1["category"] ?></h1>


        </div><!-- /header -->
	
	<ul data-role="listview">
		<li>
		<div data-role="navbar">
			<ul>
				<?php
					$query = sprintf("SELECT * from foods WHERE category_id = %s LIMIT 20", $_GET["cat_id"]);
					$result = mysql_query($query);
					if (mysql_num_rows($result) > 0){
						while($row = mysql_fetch_array($result)){
					?>
						<li><img src="<?php echo $row["image_url"] ?>" class="thumb"></li>
						<li><a href="description.php?food=<?php echo $row["id"]?>" > <?php echo $row["food"] ?> </a></li>
					<?php
						}
					} else{
						echo '<li><center>Sorry,but there is nothing in this category at the moment.</center></li>';
					}
					?>
			</ul>
		</div>
		</li>
	</ul>

</body>
