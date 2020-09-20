<html>
	
	<?php 
		//require 'general_functions.php';

		
		
		$response_query = do_query("SELECT responses.content, responses.datetimePosted, responses.userID, responses.postID
									FROM responses
									JOIN users
									ON responses.userID = users.id
									WHERE responses.id = $response_id
									");
		$response_data = mysqli_fetch_assoc($response_query);
		$user_id = $response_data["userID"];
		$user_info = mysqli_fetch_assoc(get_user_info_query($user_id));
		$category_id = get_post_category_id($response_data["postID"]);
		$credential_query = query_user_credentials_in($user_id, $category_id);
		$credential_info = mysqli_fetch_assoc($credential_query);
		$upvotes = get_vote_count($response_data["postID"], $response_id, "UP");
		$downvotes = get_vote_count($response_data["postID"], $response_id, "DOWN");
		$votes = $upvotes - $downvotes;
		//GET USER VOTE
		$user_vote = "NONE";
		if($current_user_info = get_login_user())
			$user_vote = get_vote_by($current_user_info["userID"], $response_data["postID"], $response_id);
		
		

	?>
	<body>
		<div class="response">
			<div class="w3-panel response-header <?php if (empty_query($credential_query))echo 'w3-gray'; else echo 'w3-light-green';?>">
				<div class="w3-third">	
					<div class="votes buttons w3-quarter">
						<span class="vote"><?php echo $votes;?>
						<a href="vote_script.php?vote=UP&postID=<?php echo $response_data["postID"]; ?>
													&responseID=<?php echo $response_id; ?>">
							<img height="10" src="images/upvote_colored.png" class="<?php if ($user_vote != 'UP') echo 'greyed-out'; ?>" />
						</a>
						<a href="vote_script.php?vote=DOWN&postID=<?php echo $response_data["postID"]; ?>
													&responseID=<?php echo $response_id; ?>">
							<img height="10" src="images/downvote_colored.png" class="<?php if ($user_vote != 'DOWN') echo 'greyed-out'; ?>"/>
						</a>
	
					</div>
					<span class="w3-text-black"><?php echo $user_info["Username"]; ?> </span>
					<span class="w3-text-gray"><?php if(!empty_query($credential_query)) echo $credential_info["name"]; ?></span>
				</div>
				<div class="w3-third">
					<span><?php echo $response_data["datetimePosted"];?></span>
				</div>
			</div>

			<div class="response-body w3-panel">
				<?php echo $response_data["content"]; ?>
			</div>
		</div>
		
	
	</body>


</html>