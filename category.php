<html>
	<head>
		<?php
			include 'header.php';

			$id = $_GET["id"];
			$category_query = do_query("SELECT * from categories WHERE id=$id");
			if (mysqli_num_rows($category_query) == 0) die("ERROR 404: Category not found");
			$category_info = mysqli_fetch_assoc($category_query);
		?>
		
		<title><?php echo $category_info["name"]; ?></title>
	</head>
	<body>	
		<div id="topics" class="topics w3-panel">
			<h2><?php echo $category_info["name"]; ?></h2>
			<a class="w3-button w3-hover-blue w3-green" href="add_topic.php?id=<?php echo $id; ?>">+ New Topic</a>
			<table id="topics" class="w3-hoverable forum_table w3-table w3-bordered">
			    <colgroup>
				   <col span="1" style="width: 20%;">
				   <col span="1" style="width: 50%;">
				   <col span="1" style="width: 30%;">
				</colgroup>
    
				<tr class="table_header">
					<th>Name</th>
					<th>Description</th>
					<th>Last Post</th>
				</tr>
				<?php
					$topic_results = query_topics($category_info["id"]);
					while($topic = mysqli_fetch_assoc($topic_results)){
						$topicID = $topic["id"];
						
						echo "<tr class='table_content'>";
						echo "<td><a href='./topic.php?id=$topicID'>" . $topic["name"] . "</a></td>";						
						echo "<td>" . $topic["description"] . "</td>";
						//Last post
						echo "<td>";
						$last_post_query = do_query("SELECT posts.id,posts.title, posts.datetimePosted, users.Username 
													FROM posts 
													JOIN coffee_user_db.users
													ON posts.userID = users.id
													WHERE posts.topicID = $topicID
													ORDER BY posts.datetimePosted DESC
													LIMIT 1;
													");
						
						$last_post = mysqli_fetch_assoc($last_post_query);
						if (empty($last_post))
							echo "No posts yet.";
						else{
							$lastPostID = $last_post["id"];
							$lastPostTitle = $last_post["title"];
							$lastPostDatetime = $last_post["datetimePosted"];
							$lastPostUsername = $last_post["Username"];
							echo "<a href='./post.php?id=$lastPostID'>$lastPostTitle</a><br/> $lastPostDatetime<br/>by: $lastPostUsername";
						}
						echo "</td>";
						//End Last post
						echo "</tr>";
					}
				?>
			</table>
		
		</div>
		<?php include 'footer.php'; ?>

	</body>


</html>