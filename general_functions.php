<?php
define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PWD", "");
define("DB_NAME", "coffee_db");
define("EVIDENCE_DIR", "credential_evidence/");
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
	$bb_codes =  array("[b]", "[/b]", "[i]", "[/i]", "[quote]", "[/quote]");
	$html_tags = array("<b>", "</b>", "<i>", "</i>", "<quote>", "</quote>");
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
							FROM coffee_user_db.sessions
							JOIN coffee_user_db.users
							ON sessions.userID = users.id
							WHERE sessions.id=$session_id;";
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

function is_moderator_in($user_id, $category_id){
	$moderator_query = do_query("SELECT *
						FROM coffee_user_db.categories_moderators
						WHERE userID=$user_id AND categoryID=$category_id");
	return mysqli_num_rows($moderator_query) > 0;
}

function query_moderators_in($category_id){
	return do_query("SELECT *
					FROM coffee_user_db.categories_moderators cm
					JOIN coffee_user_db.users 
					ON cm.userID = users.id
					WHERE cm.categoryID=$category_id");
								
}

function query_categories_moderated_by($user_id){
	return do_query("SELECT *
					FROM coffee_user_db.categories_moderators cm
					JOIN categories
					ON cm.categoryID = categories.id
					WHERE userID=$user_id");
}

function query_user_credentials_in($user_id, $category_id){
	$expertise_query = "SELECT cml.name, uc.evidence_file_dir 
						FROM coffee_cred_db.user_credentials uc
						JOIN coffee_cred_db.credential_category_connection ccc
						ON uc.credentialID = ccc.credentialID
						JOIN coffee_cred_db.credential_master_list cml
						ON cml.id = uc.credentialID
						WHERE ccc.categoryID=$category_id AND uc.status='APPROVED' AND uc.userID=$user_id;";
	return do_query($expertise_query);
}

//New function
function query_user_expertise($user_id){
	$expertise_query = "SELECT ccc.categoryID, categories.name
						FROM coffee_cred_db.user_credentials uc
						JOIN coffee_cred_db.credential_category_connection ccc
						ON uc.credentialID = ccc.credentialID
						JOIN coffee_cred_db.credential_master_list cml
						ON cml.id = uc.credentialID
						JOIN categories
						ON categories.id=ccc.categoryID
						WHERE uc.status='APPROVED' AND uc.userID=$user_id;";
	return do_query($expertise_query);
}

function query_user_credentials($user_id, $category_id){
	$expertise_query = "SELECT cml.name, uc.evidence_file_dir , uc.status
						FROM coffee_cred_db.user_credentials uc
						JOIN coffee_cred_db.credential_category_connection ccc
						ON uc.credentialID = ccc.credentialID
						JOIN coffee_cred_db.credential_master_list cml
						ON cml.id = uc.credentialID
						WHERE ccc.categoryID=$category_id AND uc.userID=$user_id AND uc.status='APPROVED';";
	return do_query($expertise_query);
}

function query_pending_credentials_from($category_id){
	$expertise_query = "SELECT cml.name AS 'Credential', uc.evidence_file_dir AS 'Evidence',
								users.Username AS 'Username', uc.UserID, uc.credentialID
						FROM coffee_cred_db.user_credentials uc
						JOIN coffee_cred_db.credential_category_connection ccc
						ON uc.credentialID = ccc.credentialID
						JOIN coffee_cred_db.credential_master_list cml
						ON cml.id = uc.credentialID
						JOIN coffee_user_db.users
						ON users.id = uc.userID
						WHERE ccc.categoryID=$category_id AND uc.status='PENDING'";
	return do_query($expertise_query);
}


function query_credential_ids_from($category_id){
	$expertise_query = "SELECT cml.id, cml.name
					FROM coffee_cred_db.credential_master_list cml
					JOIN coffee_cred_db.credential_category_connection ccc
					ON cml.id = ccc.credentialID	
					WHERE ccc.categoryID=$category_id;";
	return do_query($expertise_query);
}

function query_experts_from($category_id){
	$experts_query = "SELECT users.id, users.Username, uc.evidence_file_dir, cml.name AS 'Position'
						FROM coffee_cred_db.user_credentials uc
						JOIN coffee_cred_db.credential_category_connection ccc
						ON uc.credentialID = ccc.credentialID
						JOIN coffee_cred_db.credential_master_list cml
						ON cml.id = uc.credentialID
						JOIN coffee_user_db.users
						ON uc.userID = users.id
						WHERE ccc.categoryID=$category_id";
	return do_query($experts_query);
}

function query_experts_from_like($category_id, $like_query){
	$experts_query = "SELECT users.id, users.Username, uc.evidence_file_dir, cml.name AS 'Position'
						FROM coffee_cred_db.user_credentials uc
						JOIN coffee_cred_db.credential_category_connection ccc
						ON uc.credentialID = ccc.credentialID
						JOIN coffee_cred_db.credential_master_list cml
						ON cml.id = uc.credentialID
						JOIN coffee_user_db.users
						ON uc.userID = users.id
						WHERE ccc.categoryID=$category_id 
								AND users.Username LIKE '%$like_query%'";
	return do_query($experts_query);
}

function get_post_category_id($post_id){
	$query = "SELECT categoryID
				FROM posts
				JOIN topics
				ON posts.topicID = topics.id
				WHERE posts.id=$post_id";
	return mysqli_fetch_assoc(do_query($query))["categoryID"];
}


function query_response_ids_from($post_id, $sort_type="DATETIME"){
	switch($sort_type){
		case "DATETIME":
			$query_str = "SELECT id FROM responses where postID=$post_id";
			break;
		case "VOTES":
			$query_str = "SELECT responses.id
						  FROM responses 
						  LEFT JOIN vote_master_list v 
						  ON responses.id=v.responseID
						  WHERE responses.postID=$post_id
						  GROUP BY v.responseID
						  ORDER BY SUM(CASE WHEN v.vote='UP' THEN 1 WHEN v.vote='DOWN' THEN -1 ELSE 0 END) DESC";
			break;
		default:
			$query_str = "SELECT id FROM responses where postID=$post_id";
			break;
		
	}
	return do_query($query_str);
}

function get_user_info_query($user_id){
	$user_query_str = "SELECT * FROM coffee_user_db.users WHERE id=$user_id";
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

function query_posts_by($userID){
	$query_str = "SELECT * from posts WHERE userID=$userID";
	return do_query($query_str);
}

function empty_query($query_result){
	return mysqli_num_rows($query_result) == 0;
}

function get_vote_count($post_id, $response_id, $voteType){
	$vote_query = do_query("SELECT COUNT(*) AS 'count' 
							FROM vote_master_list 
							WHERE vote='$voteType' AND postID=$post_id AND responseID=$response_id");
	return mysqli_fetch_assoc($vote_query)["count"];
}

function get_vote_by($user_id, $post_id, $response_id){
	$vote_query = do_query("SELECT vote
							FROM vote_master_list
							WHERE postID=$post_id AND responseID=$response_id 
							AND voterUserID=$user_id;");
	if (empty_query($vote_query)) return "NONE";
	else{
		$vote_str = mysqli_fetch_assoc($vote_query)["vote"];
		return $vote_str;
	}						
				
}


function is_answered_by($requested_user_id, $post_id){
	$query = do_query("SELECT COUNT(*) AS 'count'
						FROM responses
						WHERE userID=$requested_user_id 
							AND postID=$post_id");
	return mysqli_fetch_assoc($query)["count"] > 0;
}


function get_answer_requests_for($user_id){
	$query_str = "SELECT * FROM answer_requests WHERE requestedUserID=$user_id";
	return do_query($query_str);
}
?>
