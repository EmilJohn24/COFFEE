<?php
	include "general_functions.php";
	$vote = $_GET["vote"];
	$post_id = $_GET["postID"];
	$response_id = $_GET["responseID"];
	if($current_user_info = get_login_user()){
		$user_id = $current_user_info["userID"];
		$current_vote = get_vote_by($user_id, $post_id, $response_id);
		if ($current_vote == "NONE")
			$vote_insertion_query = do_query("INSERT into vote_master_list(voterUserID, postID, responseID, vote)
										values($user_id, $post_id, $response_id, '$vote');
										");
		header("Location: post.php?id=$post_id");
	}

?>