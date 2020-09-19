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
		
	?>
	<body>
		<div class="response">
			<div class="w3-panel response-header <?php if (empty_query($credential_query))echo 'w3-gray'; else echo 'w3-light-green';?>">
				<div class="w3-third">	
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