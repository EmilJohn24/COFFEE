<?php include 'general_functions.php'; 
	$current_user = get_login_user();
	$current_user_id = $current_user["id"];
?>
		
<?php 
	$credential_id = 0;
	if($_POST["credential_insert_method"] == "select")
		$credential_id = intval($_POST["credential_id"]);
	else if($_POST["credential_insert_method"] == "manual"){

		$category_id = intval($_POST["category_id"]);
		$credential_name = $_POST["credential_name"];
		//NOTE: This can be turned into a function
		do_query("INSERT into credential_master_list(name) values('$credential_name')");
		$credential_id = mysqli_insert_id(get_sql_conn());
		do_query("INSERT into credential_category_connection(categoryID, credentialID) 
										values($category_id, $credential_id);");
		
	} else die("Invalid credential insertion method");
	//File upload version
	if ($_POST["evidence_method"] == "upload"){
		if (!isset($_FILES["evidence_file"])) die("File failed to upload");
		$evidence_filedir = EVIDENCE_DIR . basename($_FILES["evidence_file"]["name"]);
		if (move_uploaded_file($_FILES["evidence_file"]["tmp_name"], $evidence_filedir)){
			$credential_insertion_query = do_query("
										INSERT into user_credentials
													(userID, credentialID, evidence_file_dir)
												values($current_user_id, $credential_id, '$evidence_filedir');
										");
		} else die("Oops. Something went wrong");
	}
	else if ($_POST["evidence_method"] == "url"){
		$evidence_url = $_POST["evidence_url"];
		$credential_insertion_query = do_query("
										INSERT into user_credentials
												(userID, credentialID, evidence_file_dir)
												values($current_user_id, $credential_id, '$evidence_url');
										");
	}
	header("Location: credentials.php");


//End file upload version
?>