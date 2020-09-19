<html>
	<head>
	<?php
		include 'header.php';
		//NOTE: It might be possible to make this into a function (see category.php)
		$id = $_GET["id"];
		$post_query = do_query("SELECT * from posts WHERE id=$id");
		if (mysqli_num_rows($post_query) == 0) die("ERROR 404: Post not found");
		$post_data = mysqli_fetch_assoc($post_query);
		$user_id = $post_data["userID"];
		$user_info = mysqli_fetch_assoc(get_user_info_query($user_id));
		
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			if($current_user_info = get_login_user()){
				$current_user_id = $current_user_info["id"];
				$new_response_content = html_reformat($_POST["newResponse"]);
				$post_insert_query = do_query("INSERT into responses(content, postID, userID)
											values ('$new_response_content', $id, $user_id);
											");
			}
			else die("You must be logged in to post.");
		}
	?>
	
	</head>
	<body>
		<div class="post w3-panel">
			<div class="w3-panel post-header w3-light-blue">
				<div class="w3-third">	
					<span class="w3-text-black"><?php echo $user_info["Username"]; ?> </span>
					<span class="w3-text-gray">Asker</span>
				</div>
				<div class="w3-third">
					<span><?php echo $post_data["datetimePosted"];?></span>
				</div>
			</div>
			<div class="post-body w3-panel">
				<?php echo $post_data["content"]; ?>
			</div>
		</div>
		<?php
			$responses_id_query = query_response_ids_from($id);
			while ($response_id = mysqli_fetch_assoc($responses_id_query)["id"]){
				include 'templates/response_template.php';
			}
		?>
		
		
		<form class="w3-container" id="newPost" action="<?php echo cleanse($_SERVER['PHP_SELF']); ?>?id=<?php echo $id;?>" method="POST">
			<textarea name="newResponse" class="w3-input w3-border" rows="10" cols="10" placeholder="New Post"></textarea>
			<input type="submit" text="Post" name="post" />
		</form>
	</body>



</html>