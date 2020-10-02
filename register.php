<html>
<head>
<style>
.error{
color: red;
}
</style>
<title>COFFEE - Registration</title>
<?php
	include 'header.php';
	include 'user_functions.php';

	//Input sanitation (e.g. htmlspecialchars) in Lopez_LA9_GenericFunctions.php
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if ($_POST["password"] != $_POST["confirm_pw"])
			set_form_error("confirm_pw", "Passwords do not match");
		else if(user_register($_POST["lname"], $_POST["fname"],
							$_POST["username"], $_POST["password"], $_POST["email"])){
				echo '<script type="text/javascript">
				 alert("' . $_POST["username"] . ' registered
				successfully");
				 location.href="./login.php";
				 </script>';
				 header("Location: login.php");
		}
	}
?>
</head>
	<body>
		<div class="w3-center center">
			<h1>Register</h1>
			<form action="<?php echo cleanse($_SERVER["PHP_SELF"]); ?>" method="POST">
				<span class="error"> <?php echo get_form_error("form"); ?> </span>
				<br/>
				<input class="w3-input w3-border w3-center  w3-hover-light-gray" type="text" placeholder="Last Name" name="lname" />
				<span class="error">
					* <?php echo get_form_error("lname");?>
				</span>
				<br/>
				<input class="w3-input w3-border w3-center  w3-hover-light-gray"  type="text" placeholder="First Name" name="fname" />
				<span class="error">
					* <?php echo get_form_error("fname");?>
				</span>
				<br/>
				<input class="w3-input w3-border w3-center  w3-hover-light-gray"  type="text" placeholder="Username" name="username"/>
				<span class="error">
					* <?php echo get_form_error("username");?>
				</span>
				<br/>
				<input class="w3-input w3-border w3-center  w3-hover-light-gray"  type="password" placeholder="Password" name="password"/>
				<span class="error">
					* <?php echo get_form_error("password");?>
				</span>
				<br/>
				<input class="w3-input w3-border w3-center  w3-hover-light-gray"  type="password" placeholder="Confirm Password" name="confirm_pw"/>
				<span class="error">
					* <?php echo get_form_error("confirm_pw");?>
				</span>
				<br/>
				<input class="w3-input w3-border w3-center  w3-hover-light-gray"  type="email" placeholder="Email" name="email"/>
				<span class="error">
					* <?php echo get_form_error("email");?>
				</span>
				<br/>
				<input type="submit" value="Register" /><br/>
			</form>
		</div>
		<?php include 'footer.php';?>
	</body>
</html>