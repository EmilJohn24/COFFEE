<?php
	include './general_functions.php';
	$response_id = $_GET["id"];
	$response_info = mysqli_fetch_assoc(do_query("SELECT userID, postID from responses WHERE id=$response_id"));
	$post_id = $response_info["postID"];
	$owner_user_id = $response_info["userID"];
	$category_id = get_post_category_id($post_id);
	$current_user = get_login_user();
	$current_user_id = $current_user["id"];
	if (!$current_user) die("You do not have permission to access this.");
	if (is_moderator_in($current_user_id, $category_id) || $current_user_id == $owner_user_id){
		do_query("DELETE from responses where id=$response_id");
		header("Location: post.php?id=$post_id");
	} else ("You do not have permission to delete this.");

?>