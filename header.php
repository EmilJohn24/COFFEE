<html>
	<head>
		<?php
			include './general_functions.php';
			$current_user = get_login_user();

		?>
		<?php
			//Comment when testing
		error_reporting(0);
		?>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<link rel="stylesheet" href="styles.css">
		<style>
			.greyed-out{
				filter: grayscale(70%);

			}
			.center {
				  margin: auto;
				  width: 75%;
				  padding: 2px;
				}
		</style>
	</head>
	<body>
		<header class="w3-container w3-brown w3-display-container">
			<a href='index.php'>
				<img src='logo.png' alt="Logo" width="100"/>
			</a>
			<div id="user-section" class=" w3-container w3-display-bottomright">
				<div id='credential' class='w3-bar'>
			<?php
				if (empty($current_user)){
					echo "<a href='login.php' class='w3-bar-item w3-button w3-hover-white'>Login</a>";
					echo "<a href='register.php' class='w3-bar-item w3-button w3-hover-white'>Register</a>";
				} else{
					$current_username = $current_user["Username"];
					echo "<a class='w3-button w3-bar-item'>User: $current_username</a>";
					echo "<a class='w3-button w3-bar-item w3-hover-green' href='credentials.php'>My Credentials</a>";
					echo "<a class='w3-button w3-bar-item w3-hover-white' href='logout.php'>Logout</a>";
				}
			?>
				</div>
			</div>
		</header>
		<div class="w3-bar w3-border w3-light-grey">
		<!-- DO some PHP magic here later -->
			<div id="navigation">
				<a href="index.php" class="w3-bar-item w3-button w3-hover-red">Categories</a>
				<a href="post_dump.php" class="w3-bar-item w3-button w3-hover-green">Posts</a>
				<a href="trending.php" class="w3-bar-item w3-button w3-hover-blue">Trending</a>
				<a href="unanswered.php" class="w3-bar-item w3-button w3-hover-teal">Unanswered</a>
				<a href="my_post.php" class="w3-bar-item w3-button w3-hover-yellow">My Posts</a>
				<form action="search.php" method="GET"> 
					<input name="q" type="text" class="w3-bar-item w3-input" placeholder="Search..">
				</form>
				
			</div>
		</div>
</div>
	</body>
	

</html>