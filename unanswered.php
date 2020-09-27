<html>
	<head>
	<?php
		include 'header.php';
	?>
	</head>
	
	
	<body>
		<div class="w3-container">
			<div id="posts" class="posts w3-panel">
				<h2 class="w3-center center">Unanswered</h2>
				<table id="posts" class="forum_table w3-table w3-bordered">
					<colgroup>
					   <col span="1" style="width: 25%;">
					   <col span="1" style="width: 25%;">
					   <col span="1" style="width: 25%;">
					</colgroup>
		
					<tr class="table_header">
						<th>Name</th>
						<th>Posted by</th>
						<th>Topic</th>
						<th>Views</th>

					</tr>
					<?php
						$post_results = do_query("SELECT *, COUNT(vml.userID) as 'views' 
													from posts
													JOIN view_master_list vml
													ON vml.postID = posts.id
													GROUP BY vml.postID
													ORDER BY COUNT(vml.userID) DESC
													");
						while($post = mysqli_fetch_assoc($post_results)){
							$postID = $post["id"];
							$topicID = $post["topicID"];
							$views = $post["views"];
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
							if ($reply_count != 0) continue;
							echo "<tr class='table_content'>";
							echo "<td><a href='./post.php?id=$postID'>" . $post["title"] . "</a></td>";	
							$posterUserID = $post["userID"];
							$posterUsername =  mysqli_fetch_assoc(get_user_info_query($posterUserID))["Username"];
							echo "<td>$posterUsername</td>";
							$topic_name = mysqli_fetch_assoc(do_query("SELECT name FROM topics WHERE id=$topicID"))["name"];
							echo "<td><a href='topic.php?id=$topicID'>$topic_name</a></td>";
							echo "<td>$views</td>";
							echo "</tr>";
						}
					?>
				</table>
			
			</div>
				
		
		</div>
		<?php include 'footer.php'; ?>
	</body>



</html>