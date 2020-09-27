<html>
	<head>
		<?php include 'header.php'; 
		$current_user_id = 0;
		if($current_user_info = get_login_user()){
			$current_user_id = $current_user_info["id"];
		} else header("Location: login.php");
		
		?>

	</head>
	<body>	
	
		<div class="w3-container w3-cell-row" id="content">
			<div id="posts" class="posts w3-container w3-cell">
				<div>
					<h2>My Posts</h2>
				</div>
				<table id="my-posts" class="w3-forum_table w3-table w3-bordered w3-hoverable">
					<colgroup>
					   <col span="1" style="width: 20%;">
					   <col span="1" style="width: 30%;">
					   <col span="1" style="width: 10%;">
					</colgroup>
		
					<tr class="table_header">
						<th>Name</th>
						<th>Last Post</th>
						<th>Reply Count</th>
					</tr>
					<?php
					$post_results = query_posts_by($current_user_id);
					while($post = mysqli_fetch_assoc($post_results)){
						$postID = $post["id"];
						echo "<tr class='table_content'>";
						echo "<td><a href='./post.php?id=$postID'>" . $post["title"] . "</a></td>";	
						$posterUserID = $post["userID"];
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
			<div id="right-side-bar" class="w3-cell">
				<?php include 'right_side_bar.php'; ?>
			</div>
		</div>
		<?php include 'footer.php'; ?>
	</body>

</html>