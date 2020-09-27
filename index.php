<html>
	<head>
		<?php include 'header.php'; ?>

	</head>
	<body>	
	
		<div class="w3-container w3-cell-row" id="content">
			<div id="categories" class="categories w3-panel w3-cell">
				<div>
					<h2>Categories</h2>
					<a class="w3-right w3-button w3-hover-blue w3-green" href="add_category.php">+ New Category</a>
				</div>
				<table id="categories" class="w3-forum_table w3-table w3-bordered w3-hoverable">
					<colgroup>
					   <col span="1" style="width: 20%;">
					   <col span="1" style="width: 70%;">
					   <col span="1" style="width: 10%;">
					</colgroup>
		
					<tr class="table_header">
						<th>Name</th>
						<th>Description</th>
						<th>Creator</th>
					</tr>
					<?php
						$category_results = query_categories();
						while($category = mysqli_fetch_assoc($category_results)){
							echo "<tr class='table_content'>";
							$categoryID = $category["id"];
							echo "<td><a href='./category.php?id=$categoryID'>" . $category["name"] . "</a></td>";						
							echo "<td>" . $category["description"] . "</td>";
							$creatorID = $category["creatorID"];
							$creator_query = do_query("SELECT users.Username as 'creator' FROM coffee_user_db.users WHERE users.id=$creatorID");
							echo "<td>" . mysqli_fetch_assoc($creator_query)["creator"]. "</td>";
							echo "</tr>";
						}
					?>
				</table>
			
			</div>
			<div id="right-side-bar" class="w3-cell">
				<?php include 'right_side_bar.php'; ?>
			</div>
		</div>
		<?php include 'footer.php'; ?>
	</body>

</html>