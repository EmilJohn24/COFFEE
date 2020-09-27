<?php
	$error_collection = array();
	function collect_form_errors(){
		global $error_collection, $required_fields;
		//required field checking
		foreach(array_keys($_POST) as $name){
		if (empty($_POST[$name]))
			$error_collection[$name] = ucfirst($name) . " is required!";
		}
	}
	function top_level_form_error($str){
		set_form_error("form", $str);
	}
	
	function set_form_error($name, $str){
		global $error_collection;
		$error_collection[$name] = $str;
	}
	

	//returns the session ID on successful login
	define("SESSION_ID_MIN", pow(10, 6));
	define("SESSION_ID_MAX", pow(10, 7) - 1);
	function user_login($username, $password){
		global $rec_sql_conn;
		$login_query_str = "SELECT id FROM coffee_user_db.users WHERE Username='$username' AND Password='$password'";
		if($login_query = mysqli_query($rec_sql_conn, $login_query_str)){
			if(mysqli_num_rows($login_query) == 1){
				$login_id = mysqli_fetch_array($login_query)['id'];
				$session_id = rand(SESSION_ID_MIN, SESSION_ID_MAX);
				$session_insertion_query_str = "INSERT into coffee_user_db.sessions(id, userID) values($session_id, $login_id);";
				if ($session_insert_query = mysqli_query(get_sql_conn(), $session_insertion_query_str))
					return $session_id;
				else die("Login failed: session could not be initialized" . mysqli_error(get_sql_conn()));
			}
			return false;
			} else{
			die("Login failed: Unable to look up username. Error: " . mysqli_error(get_sql_conn()));	
		}
	}
	
	
	function username_check($username){
		global $rec_sql_conn;
		$username_check_query_str = "SELECT * FROM coffee_user_db.users WHERE
		UserName='$username'";
		if ($check_query = mysqli_query($rec_sql_conn, $username_check_query_str)){
			return mysqli_num_rows($check_query) == 0;
		} else{
			top_level_form_error("Username check failed" . mysqli_error($rec_sql_conn));
		}
	}
	
	
	
	function user_register($lname, $fname, $username, $password, $email){
		global $rec_sql_conn, $error_collection;
		$register_query_str = "INSERT INTO coffee_user_db.users(LastName, FirstName,
							Username, Password, Email)
			values('$lname', '$fname', '$username', '$password', '$email')";
		if (count($error_collection) > 0) return false;
		elseif (username_check($username)){
			if (!mysqli_query($rec_sql_conn, $register_query_str)){
				top_level_form_error("Registration failed: " . mysqli_error($rec_sql_conn));
				return false;
			}         
			else return true;
		} else{
			top_level_form_error("Username already exists.");
			return false;
		}
	}
	function get_form_error($name){
		global $error_collection;
		if (array_key_exists($name, $error_collection)) return $error_collection[$name];
		else return "";
	}
	//GLOBAL OPS
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		collect_form_errors();
		post_form_cleansing(); //cleans all form content simultaneiously
	}


?>