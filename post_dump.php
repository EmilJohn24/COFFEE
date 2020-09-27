<html>
	<head>
	<?php
		include 'header.php';
	?>
	</head>
	
	
	<body>
		<div id="posts" class="w3-container">
		<div id="posts" class="posts w3-panel">
			<table id="posts" class="forum_table w3-table w3-bordered">
			    <colgroup>
				   <col span="1" style="width: 20%;">
				   <col span="1" style="width: 20%;">
				   <col span="1" stype="width: 20%;">
				   <col span="1" style="width: 20%;">
				   <col span="1" style="width: 20%;">
				</colgroup>
    
				<tr class="table_header">
					<th>Name</th>
					<th>Posted by</th>
					<th>Last Reply By</th>
					<th>Reply Count</th>
					<th>Topic</th>
				</tr>
				<?php
					$post_results = do_query("SELECT * from posts ORDER BY datetimePosted DESC");;
					while($post = mysqli_fetch_assoc($post_results)){
						$postID = $post["id"];
						$topicID = $post["topicID"];
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
						$topic_name = mysqli_fetch_assoc(do_query("SELECT name FROM topics WHERE id=$topicID"))["name"];
						echo "<td><a href='topic.php?id=$topicID'>$topic_name</a></td>";
						echo "</tr>";
					}
				?>
			</table>
		
		</div>
			
		
		</div>
		<?php include 'footer.php'; ?>
	</body>



</html>