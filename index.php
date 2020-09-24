<html>
	<head>
		<?php include 'header.php'; ?>

	</head>
	<body>	
		<div id="categories" class="categories w3-panel">
			<table id="categories" class="forum_table w3-table w3-bordered">
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
		
	</body>

</html>