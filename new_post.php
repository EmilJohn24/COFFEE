<html>
	<head>
		<?php
			include "header.php";
			$topicID = $_GET["id"];
			if ($_SERVER["REQUEST_METHOD"] == "POST"){
				if($current_user_info = get_login_user()){
					$userID = $current_user_info["id"];
					$title = $_POST["title"];
					$content = html_reformat($_POST["content"]);
					$insertion_query = do_query("INSERT into posts(title, content, topicID, userID) 
												values('$title', '$content', $topicID, $userID);");
					header("Location: topic.php?id=$topicID");
				} else die("You must be logged in to post.");				
			}

		?>
		<title>New Post</title>
	
	</head>
	<body>
		<form class="w3-center center" action="<?php echo cleanse($_SERVER['PHP_SELF']);?>?id=<?php echo $topicID; ?>" method="POST">
				<label for="title">Title</label>
				<input class="w3-input w3-border w3-hover-light-gray" name="title" placeholder="Title" type="text" /><br/>
				<label for="content">Content:</label><br/>
				<textarea name="content" class="w3-input w3-border w3-hover-light-gray" rows="10" cols="10" placeholder="New Post"></textarea>
				<input class="w3-input w3-green" type="submit" text="Post" name="post" />
		</form>
		<?php include 'footer.php'; ?>
	</body>


</html>