<html>
	<head>
		<?php
			include 'header.php';
			//NOTE: It might be possible to make this into a function (see category.php)
			$id = $_GET["id"];
			$topic_query = do_query("SELECT * from topics WHERE id=$id");
			if (mysqli_num_rows($topic_query) == 0) die("ERROR 404: Topic not found");
			$topic_info = mysqli_fetch_assoc($topic_query);
		?>
		
		<title><?php echo $category_info["name"]; ?></title>
	</head>
	<body>
		<div id="posts" class="posts w3-panel">
			<a href="./new_post.php?id=<?php echo $id;?>">New Post</a>
			<table id="posts" class="forum_table w3-table w3-bordered">
			    <colgroup>
				   <col span="1" style="width: 20%;">
				   <col span="1" style="width: 40%;">
				   <col span="1" style="width: 30%;">
				   <col span="1" style="width: 10%;">
				</colgroup>
    
				<tr class="table_header">
					<th>Name</th>
					<th>Posted by</th>
					<th>Last Reply By</th>
					<th>Reply Count</th>
				</tr>
				<?php
					$post_results = query_posts($topic_info["id"]);
					while($post = mysqli_fetch_assoc($post_results)){
						$postID = $post["id"];
						echo "<tr class='table_content'>";
						echo "<td><a href='./post.php?id=$postID'>" . $post["title"] . "</a></td>";	
						$posterUserID = $post["userID"];
						$posterUsername =  mysqli_fetch_assoc(get_user_info_query($posterUserID))["Username"];
						echo "<td>$posterUsername</td>";
						//Last reply
						echo "<td>";
						
						$reply_query = do_query("SELECT posts.title, posts.datetimePosted, users.Username 
													FROM responses 
													JOIN posts
													ON responses.postID = posts.id
													JOIN coffee_user_db.users
													ON responses.userID = users.ID
													WHERE responses.postID = $postID
													ORDER BY posts.datetimePosted DESC
													");
						$reply_count = mysqli_num_rows($reply_query);
						$last_reply = mysqli_fetch_assoc($reply_query);
						if (empty($last_reply))
							echo "No replies yet.";
						else{
							$lastReplyDatetime = $last_reply["datetimePosted"];
							$lastReplyUsername = $last_reply["Username"];
							echo "by: $lastReplyUsername <br/> on $lastReplyDatetime";
						}
						
						echo "</td>";
						//End Last reply
						echo "<td>$reply_count</td>";
						echo "</tr>";
					}
				?>
			</table>
		
		</div>
	</body>


</html>