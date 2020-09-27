<html>
	<head>
		<?php
			include "header.php";
			if ($_SERVER["REQUEST_METHOD"] == "POST"){
				if($current_user_info = get_login_user()){
					$userID = $current_user_info["id"];
					$name = $_POST["name"];
					$description = html_reformat($_POST["description"]);
					$insertion_query = do_query("INSERT into categories(name, description, creatorID) 
												values('$name', '$description', $userID);");
					$category_id = mysqli_insert_id(get_sql_conn());
					$moderator_add_query = do_query("INSERT into coffee_user_db.categories_moderators(userID, categoryID) VALUES($userID, $category_id);");
					header("Location: index.php");
				} else die("You must be logged in to add a category.");				
			}

		?>
	
	</head>
	<body>
		<div class="w3-container w3-center center">
			<form action="<?php echo cleanse($_SERVER['PHP_SELF']);?>" method="POST">
					<label for="name">Name:</label>
					<input class="w3-hover-light-gray w3-input w3-border" name="name" placeholder="Name" type="text" /><br/>
					<label for="description">Description:</label><br/>
					<textarea name="description" class="w3-hover-light-gray w3-input w3-border" rows="10" cols="10" placeholder="Category Description"></textarea>
					<input type="submit" class="w3-button w3-input w3-hover-brown w3-cyan" text="New Category" name="category" />
			</form>
		</div>
		<?php include 'footer.php'; ?>
	</body>


</html>