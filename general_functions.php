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
	return mysql_fetch_assoc($session_user);
}


function get_login_user(){
	if (!empty($_COOKIE["SESSION_ID"]))
		return get_session_user($_COOKIE["SESSION_ID"]);
	return false;
}

function get_user_info_query($user_id){
	$user_query_str = "SELECT * 
						FROM users
						where id=$user_id";
	if ($query = mysqli_query(get_sql_conn(), $user_query_str))
		return $query;
	else die("User not found: " . mysqli_error(get_sql_conn()));
	
}

function do_query($query_str){
	if ($query = mysqli_query(get_sql_conn(), $query_str))
		return $query;
	else die("Query failed: " . $query_str);
}

function query_categories(){
	$categories_query_str = "SELECT * from categories;";
	return do_query($categories_query_str);
}
?>
