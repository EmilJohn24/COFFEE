<?php
define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PWD", "");
define("DB_NAME", "coffee_db");
//SQL setup
$rec_sql_conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PWD);
if (!$rec_sql_conn) die();
use_db(DB_NAME);
function cleanse($str){
	return trim(
		htmlspecialchars(
			stripslashes($str)
		)
	);
}

function html_reformat($str){
	$str = cleanse($str);
	$str = str_replace("\n", "<br/>", $str);
	$bb_codes =  array("[b]", "[/b]", "[i]", "[/i]");
	$html_tags = array("<b>", "</b>", "<i>", "</i>");
	$str = str_replace($bb_codes, $html_tags, $str);
	//Add others later
	return $str;
}

function get_sql_conn(){
	global $rec_sql_conn;
	return $rec_sql_conn;
}

function use_db($table_name){
	global $rec_sql_conn;
	$rec_table_connect = mysqli_select_db($rec_sql_conn, $table_name);
	if (!$rec_table_connect) die("Unable to select: " . mysqli_error($rec_sql_conn));
}
function post_form_cleansing(){
		foreach($_POST as $name => &$value)
		$value = cleanse($value);
	}
	
function get_session_user($session_id){
	$session_user_query_str = "SELECT *
							FROM sessions
							JOIN users
							ON sessions.userID = users.id";
	$session_user = mysqli_query(get_sql_conn(), $session_user_query_str);
	return mysqli_fetch_assoc($session_user);
}


function get_login_user(){
	if (!empty($_COOKIE["SESSION_ID"]))
		return get_session_user($_COOKIE["SESSION_ID"]);
	return false;
}

	

function do_query($query_str){
	if ($query = mysqli_query(get_sql_conn(), $query_str))
		return $query;
	else die("Query failed: " . $query_str);
}

function query_user_credentials_in($user_id, $category_id){
	$expertise_query = "SELECT cml.name, uc.evidence_file_dir 
						FROM user_credentials uc
						JOIN credential_category_connection ccc
						ON uc.credentialID = ccc.credentialID
						JOIN credential_master_list cml
						ON cml.id = uc.credentialID
						WHERE ccc.categoryID=$category_id AND uc.status='APPROVED' AND uc.userID=$user_id;";
	return do_query($expertise_query);
}

function get_post_category_id($post_id){
	$query = "SELECT categoryID
				FROM posts
				JOIN topics
				ON posts.topicID = topics.id
				WHERE posts.id=$post_id";
	return mysqli_fetch_assoc(do_query($query))["categoryID"];
}

function query_response_ids_from($post_id){
	$query_str = "SELECT id FROM responses where postID=$post_id";
	return do_query($query_str);
}

function get_user_info_query($user_id){
	$user_query_str = "SELECT * FROM users WHERE id=$user_id";
	return do_query($user_query_str);
}

function query_categories(){
	$categories_query_str = "SELECT * from categories;";
	return do_query($categories_query_str);
}

function query_topics($categoryID){
	$query_str = "SELECT * from topics WHERE categoryID=$categoryID";
	return do_query($query_str);
}

function query_posts($topicID){
	$query_str = "SELECT * from posts WHERE topicID=$topicID";
	return do_query($query_str);
}

function empty_query($query_result){
	return mysqli_num_rows($query_result) == 0;
}
?>
