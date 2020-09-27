<html>
	<?php include "../general_functions.php";
		$category_id = $_GET["categoryID"];
	?>
	<head>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
	
	<form class="moderator-add w3-center" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
					<!--q for query-->
		Search <input type="text" class="w3-border w3-input w3-center  w3-hover-light-gray" name="user_query"/> <br/>
		<input type="hidden" name="categoryID" value="<?php echo $category_id; ?>"/>
	</form>
		<table id="search_results" class="forum_table w3-table-all w3-hoverable w3-border w3-row w3-table">
			    <colgroup>
				   <col span="1" style="width: 80%;">
				   <col span="1" style="width: 20%;">
				</colgroup>
    
				<tr class="table_header">
					<th>Name</th>
					<th>Add</th>
				</tr>
				
				<?php
					if (isset($_GET["user_query"])){
						$experts_query = query_experts_from_like($category_id, $_GET["user_query"]);
						while ($expert_info = mysqli_fetch_assoc($experts_query)){
							$expert_username = $expert_info["Username"];
							$expert_id = $expert_info["id"];
							echo "<tr>";
								echo "<td>$expert_username</td>";
								echo "<td><a 
									href='add_moderator_script.php?userID=$expert_id&categoryID=$category_id'>
									Add</a>";
							echo "</tr>";
						}
					}
				?>
		</table>
	</body>
</html>