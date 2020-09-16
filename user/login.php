<html>
<head>
<style>
.error{
color: red;
}
</style>
<title>Lopez - Login Page</title>
<?php
	include 'user_functions.php';
//Input sanitation (e.g. htmlspecialchars) and validation in Lopez_LA9_GenericFunctions.php
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if($session_id = user_login($_POST["username"],
		$_POST["password"])){
			setcookie("SESSION_ID", $session_id, time() + (86400 * 30),  "/");
			header('Location: http://' . $_SERVER['SERVER_NAME'] . '/COFFEE/index.php');
			//put redirection to main page here
		}
			
	else top_level_form_error("Username/Password incorrect");
}
?>
</head>
	<body>
		<h1>Login</h1>
		<form action="<?php echo cleanse($_SERVER["PHP_SELF"]); ?>" method="POST">
			<span class="error"> <?php echo get_form_error("form"); ?> </span>
			<br/>
			<input type="text" placeholder="Username" name="username"/>
			<span class="error">* <?php echo get_form_error("username");?></span>
			<br/>
			<input type="password" placeholder="Password" name="password"/>
			<span class="error">* <?php echo get_form_error("password");?></span>
			<br/>
			<input type="submit" value="Login" style="margin: 10px;"/>
			<a href="register.php">
			<input type="button" value="Register"/>
			</a>
		</form>
	</body>
</html>
