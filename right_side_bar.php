<html>
	<head>
	<?php
		$current_user = get_login_user();
		$current_user_id = 0;
		if ($current_user)
			$current_user_id = $current_user["id"];
		
	?>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<div class="w3-sidebar-top w3-threequarters w3-center w3-border w3-right <?php if(empty($current_user)) echo 'w3-hide'; ?>">
			<div class="answer-requests">
				<h2 class="w3-panel w3-brown">Answer Requests</h2>
				<ul class="w3-ul">
					<!--<li class="w3-bar">
						
					  <div class="w3-bar-item">
						<span class="w3-large">Mike</span><br>
						<span>Web Designer</span>
					  </div>
					</li>-->
					<?php
					if(!empty($current_user)){
						$a2a_query = get_answer_requests_for($current_user_id);
						if (mysqli_num_rows($a2a_query) == 0) echo "<span class='w3-center'>None yet.</span>";
						while ($a2a_request = mysqli_fetch_assoc($a2a_query)){
							$requestor_user_info = mysqli_fetch_assoc(get_user_info_query($a2a_request["requestorUserID"]));
							$requestor_username = $requestor_user_info["Username"];
							$post_id = $a2a_request["postID"];
							$post_info =  mysqli_fetch_assoc(do_query("SELECT * from posts WHERE id=$post_id"));
							$post_title = $post_info["title"];
							$bar_color = 'w3-red';
							$answered_by = is_answered_by($current_user_id, $post_id);
							if ($answered_by) $bar_color = 'w3-green';
							echo "<li class='w3-bar $bar_color'>";
								echo "<div class='w3-bar-item'>";
								echo "<span class='w3-large'>$post_title</span><br>";
								echo "<span>Requested by $requestor_username</span><br>";
								if (!$answered_by)
									echo "<span><a href='post.php?id=$post_id'>Answer</a></span><br>";
								else echo "<span>Already answered</span>";
								echo "</div>";
							echo "</li>";
						}
					}
					?>
				</ul>
			
			</div>
			<div class="my-categories">
				<h2 class="w3-panel w3-brown">Moderated</h2>
				<ul class="w3-ul">
					<!--<li class="w3-bar">
						
					  <div class="w3-bar-item">
						<span class="w3-large">Mike</span><br>
						<span>Web Designer</span>
					  </div>
					</li>-->
					<?php
					if(!empty($current_user)){
						$moderated_query = query_categories_moderated_by($current_user_id);
						if (mysqli_num_rows($moderated_query) == 0) echo "<span class='w3-center'>None yet.</span>";
						while ($mod_category = mysqli_fetch_assoc($moderated_query)){
							$mod_title = $mod_category["name"];
							$mod_id = $mod_category["id"];
							echo "<a class='w3-button w3-hover-brown' href='moderator.php?id=$mod_id'>
									<li class='w3-bar'>";
								echo "<div class='w3-bar-item'>";
								echo "<span class='w3-large'>$mod_title</span><br>";
								echo "</div>";
							echo "</li></a>";
						}
					}
					?>
				</ul>
			
			</div>
			<div class="my-expertise">
				<h2 class="w3-panel w3-brown" style="width:100%">List of Expertise</h2>
				
				<?php
					if(!empty($current_user)){
						$expertise_query = query_user_expertise($current_user_id);
						if (mysqli_num_rows($expertise_query) == 0) echo "<span class='w3-center'>None yet.</span>";
						while ($expertise = mysqli_fetch_assoc($expertise_query)){
							$exp_name = $expertise["name"];
							$exp_id = $expertise["categoryID"];
							echo "<a class='w3-button w3-hover-brown' href='category.php?id=$exp_id'>
									<li class='w3-bar'>";
								echo "<div class='w3-bar-item'>";
								echo "<span class='w3-large'>$exp_name</span><br>";
								echo "</div>";
							echo "</li></a>";
						}
					}
				
				?>
		</div>
		</div>
	</body>

</html>