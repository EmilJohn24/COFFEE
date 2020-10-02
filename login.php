<html>
<head>
<style>
	.error{
	color: red;
	}
</style>
<title>COFFEE - Login</title>
<?php
	include 'header.php';
	include 'user_functions.php';

//Input sanitation (e.g. htmlspecialchars) and validation in Lopez_LA9_GenericFunctions.php
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if($session_id = user_login($_POST["username"],
		$_POST["password"])){
			setcookie("SESSION_ID", $session_id, time() + (86400 * 30),  "/");
			header('Location: index.php');
			//put redirection to main page here
		}
			
	else top_level_form_error("Username/Password incorrect");
}
?>
</head>
	<body>
		<div class="w3-center center">
			<h1>Login</h1>
			<form class="w3-form" action="<?php echo cleanse($_SERVER["PHP_SELF"]); ?>" method="POST">
				<span class="error"> <?php echo get_form_error("form"); ?> </span>
				<br/>
				<input class="w3-border w3-center w3-hover-light-gray w3-input" type="text" placeholder="Username" name="username"/>
				<span class="error">* <?php echo get_form_error("username");?></span>
				<br/>
				<input class="w3-border w3-hover-light-gray w3-center w3-input" type="password" placeholder="Password" name="password"/>
				<span class="error">* <?php echo get_form_error("password");?></span>
				<br/>
				<input type="submit" value="Login" style="margin: 10px;"/>
				<a href="register.php">
				<input type="button" value="Register"/>
				</a>
			</form>
		</div>
	</body>
		
	<?php include 'footer.php';?>

</html>
