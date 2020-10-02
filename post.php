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
		//view counter
		if($current_user_info = get_login_user()){
			$current_user_id = $current_user_info["id"];
			$view_counter_query = do_query("INSERT into view_master_list(postID, userID) VALUES($id, $current_user_id)");
		}
		
		//end view counter
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			if($current_user_info = get_login_user()){
				$current_user_id = $current_user_info["id"];
				$new_response_content = html_reformat($_POST["newResponse"]);
				$post_insert_query = do_query("INSERT into responses(content, postID, userID)
											values ('$new_response_content', $id, $current_user_id);
											");
			}
			else die("You must be logged in to post.");
		}
		
	?>
	
	<title>COFFEE - <?php echo $post_data["title"]; ?></title>

	
	</head>
	<body class="w3-light-gray">
		<div class="post w3-panel">
			<h2><?php echo $post_data["title"];?></h2>
			<div class="w3-panel post-header w3-dark-gray">
				<div class="w3-third">	
					<span><?php echo $user_info["Username"]; ?> </span>
					<span class="w3-text-cyan">Asker</span>
				</div>
				<div class="w3-third">
					<span><?php echo $post_data["datetimePosted"];?></span>
				</div>
			</div>
			<div class="w3-white">
				<div class="post-body w3-panel">
					<?php echo $post_data["content"]; ?>
				</div>
				<div class="w3-right utilities w3-panel">
					
					 <a class="w3-dark-gray w3-button" href="post.php?id=<?php echo $id; ?>&sort=VOTES">Sort by Votes</a>
					<a class="w3-dark-gray w3-button" href="a2a.php?id=<?php echo $id; ?>">Request for Answer</a>
				</div>
			</div>
		</div>
		<div class="w3-light-gray responses">
			<?php
				$responses_id_query = query_response_ids_from($id, $_GET["sort"]);
				while ($response_id = mysqli_fetch_assoc($responses_id_query)["id"]){
					include 'templates/response_template.php';
				}
			?>
		</div>
		
		
		<form class="w3-container" id="newResponse" action="<?php echo cleanse($_SERVER['PHP_SELF']); ?>?id=<?php echo $id;?>" method="POST">
			<?php
			$newResponseClass = 'w3-border';
			if($current_user_info = get_login_user()){
				$current_user_id = $current_user_info["id"];
				$category_id = get_post_category_id($id);
				$credential_query = query_user_credentials_in($current_user_id, $category_id);
				if (!empty_query($credential_query)) {
					echo "<a href='w3-right' class='w3-button w3-green w3-hover-blue'>&check; Expert</a>";
					$newResponseClass = "w3-border-green w3-bar w3-topbar w3-bottombar w3-leftbar w3-rightbar";
				}
			}
				
			?>
			<textarea name="newResponse" class="w3-input w3-border <?php echo $newResponseClass; ?>" rows="5" cols="1" placeholder="New Answer"></textarea>
			<input class="w3-input w3-button w3-right w3-cyan" type="submit" text="Post" name="post" />
		</form>
		<?php include 'footer.php'; ?>
	</body>



</html>