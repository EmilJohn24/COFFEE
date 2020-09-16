<html>
	<head>
		<?php include 'header.php'; ?>

	</head>
	<body>	
		<div id="categories" class="categories w3-panel">
			<?php
				$category_results = query_categories();
				while($category = mysqli_fetch_assoc($category_results)){
					echo "<div class='w3-panel category'>";
					echo $category["name"];
					
					echo "</div>";
				}
			?>
		
		</div>
		
	</body>

</html>