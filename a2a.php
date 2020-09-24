<html>
	<head>
		<?php
			include 'header.php';
			$current_user = get_login_user();
			if (empty($current_user)) die("You must be logged in to use this feature.");
			$current_user_id = $current_user["id"];
			$requestor_user_id = $current_user_id;
			$post_id = $_GET["id"];		
			$post_query = do_query("SELECT * from posts WHERE id=$post_id");
			$post_info = mysqli_fetch_assoc($post_query);
			$poster_user_id = $post_info["userID"];
			$poster_user_info = mysqli_fetch_assoc(get_user_info_query($poster_user_id));
			$category_id = get_post_category_id($post_id);
			$php_self = cleanse($_SERVER["PHP_SELF"]);
			
			
			if (isset($_GET["userID"])){
				$requested_user_id = $_GET["userID"];
				$request_insert_query = do_query("INSERT into answer_requests(requestorUserID, requestedUserID, postID) 
													VALUES($requestor_user_id, $requested_user_id, $post_id)");
				header("Location: post.php?id=$post_id");
			}
		?>
	</head>
	
	<body>
		<div class="post w3-panel">
			<div class="w3-panel post-header w3-light-blue">
				<div class="w3-third">	
					<span class="w3-text-black"><?php echo $poster_user_info["Username"]; ?> </span>
					<span class="w3-text-gray">Asker</span>
				</div>
				<div class="w3-third">
					<span><?php echo $post_info["datetimePosted"];?></span>
				</div>
			</div>
			<div class="post-body w3-panel">
				<?php echo $post_info["content"]; ?>
			</div>
		</div>
		<div class="w3-panel">
			<form class="w3-container" method="GET" action="<?php echo $php_self; ?>">
				<label>Search Expert</label>
				<input type="text" name="q">
				<input type="hidden" name="id" value="<?php echo $post_id; ?>">
				<input type="submit" name="submit" text="Search">
			</form>
			
			<table id="search_results" class="forum_table w3-table w3-bordered">
			    <colgroup>
				   <col span="1" style="width: 40%;">
				   <col span="1" style="width: 40%;">
				   <col span="1" style="width: 20%;">

				</colgroup>
    
				<tr class="table_header">
					<th>Name</th>
					<th>Credential</th>
					<th>Request</th>
				</tr>
				
				<?php
					$experts_query = (isset($_GET["q"]) ? query_experts_from_like($category_id, $_GET["q"]) : query_experts_from($category_id));
					while ($expert_info = mysqli_fetch_assoc($experts_query)){
						$expert_username = $expert_info["Username"];
						$expert_id = $expert_info["id"];
						$expert_evidence = $expert_info["evidence_file_dir"];
						$expert_position = $expert_info["Position"];
						echo "<tr>";
							echo "<td>$expert_username</td>";
							echo "<td><a href='$expert_evidence'>$expert_position</a></td>";
							echo "<td><a href='$php_self?id=$post_id&userID=$expert_id'>Add</a></td>";
						echo "</tr>";
					}
				?>
			</table>
		
		</div>		
	</body>


</html>