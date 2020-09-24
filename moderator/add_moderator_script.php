<?php
 //?userID=$expert_id&categoryID=$category_id
	include "../general_functions.php";
	$current_user = get_login_user();
	$current_user_id = $current_user["id"];
	$user_id = $_GET["userID"];
	$category_id = $_GET["categoryID"];
	
	if (!is_moderator_in($current_user_id, $category_id))die("Restricted access: You are not a moderator");
	else{
		$insertion_query = do_query("INSERT into categories_moderators(userID, categoryID)
									VALUES($user_id, $category_id)");
		header("Location: add_moderator.php?categoryID=$category_id");
	}

?>