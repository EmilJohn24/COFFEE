<?php
	include "../general_functions.php";
	$credentialID = $_GET["credentialID"];
	$userID = $_GET["userID"];
	$categoryID = $_GET["categoryID"];
	$action = $_GET["action"];
	$current_user = get_login_user();
	$current_user_id = $current_user["id"];
	if (!is_moderator_in($current_user_id, $categoryID))die("Restricted access: You are not a moderator");
	$cred_action_query = do_query("UPDATE coffee_cred_db.user_credentials
									SET status='$action'
									WHERE userID=$userID AND credentialID=$credentialID");
	header("Location: ../moderator.php?id=$categoryID");

?>