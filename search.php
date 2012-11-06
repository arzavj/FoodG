<html>
	<head>
		<?php
			include("head.php");
		?>
	</head>
	<body>
		
<!-- Main view -->
<div data-role="page" data-add-back-btn="true">

	<div data-role="header">
		<h1>My Fridge</h1>
		<a href="logout.php" data-role="button" >Logout</a>
	</div><!-- /header -->

	<div data-role="content">
		
		<p>
        	<input type="text" id="searchField" placeholder="Search">
        	<ul id="suggestions" data-role="listview" data-inset="true"></ul>
        </p>
		
	</div><!-- /content -->
	<?php
		include("footer.php");
	?>

</div>

<script type="text/javascript">
	fill();
  	$("#searchField").on("input", function(e) {
    	fill();
    });

    function fill(){
    	$.post("ajaxSearch.php", {search:$("#searchField").val()}, function(data) {
    		var sugList = $("#suggestions");
			sugList.html(data);
			sugList.listview("refresh");
		});
    }
</script>

		
	</body>
</html>