<html>
	<head>
		<?php
			include "header.php";
			$categoryID = $_GET["id"];
			if ($_SERVER["REQUEST_METHOD"] == "POST"){
				if($current_user_info = get_login_user()){
					$userID = $current_user_info["id"];
					$name = $_POST["name"];
					$description = html_reformat($_POST["description"]);
					$insertion_query = do_query("INSERT into topics(name, description, categoryID) 
												values('$name', '$description', $categoryID);");
					header("Location: category.php?id=$categoryID");
				} else die("You must be logged in to post.");				
			}

		?>
	
	</head>
	<body>
		<div class="w3-center w3-container center">
			<h2>Add Topic</h2>
			<form action="<?php echo cleanse($_SERVER['PHP_SELF']);?>?id=<?php echo $categoryID; ?>" method="POST">
					<label for="name"></label>
					<input name="name" class="w3-hover-light-gray w3-input w3-border" placeholder="Name" type="text" /><br/>
					<label for="description">Description:</label><br/>
					<textarea name="description" class="w3-input w3-border w3-hover-light-gray" rows="10" cols="10" placeholder="Topic Description"></textarea>
					<input class="w3-input w3-button w3-hover-brown w3-light-blue" type="submit" text="New Topic" name="topic" />
			</form>
		</div>
		<?php include 'footer.php'; ?>
	</body>


</html>