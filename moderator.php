<html>
	<head>
		<?php 
			include 'header.php';
			$id = $_GET["id"]; //category_id
			$current_user = get_login_user();
			if (empty($current_user)) die("Consider logging in first.");
			
			$category_query = do_query("SELECT * from categories where id=$id");
			$category_info = mysqli_fetch_assoc($category_query);
			$category_title = $category_info["name"];
			$current_user_id = $current_user["id"];
			if (!is_moderator_in($current_user_id, $id))die("Restricted access: You are not a moderator");

		?>
	</head>
	
	<body>
		<div>
			<div id="moderators" class="w3-container">
				<h2><?php echo $category_title; ?> Moderation Page</h2>
				<div id="expert-search" class="search w3-container w3-center center">
					<h2>Add Moderator</h2>

					<iframe style="width:60%;" class="w3-center w3-border" src="moderator/add_moderator.php?categoryID=<?php echo $id;?>" name="user_search">
					
					</iframe>
				</div>
				<div id="moderators" class="moderator-list w3-container w3-center center">
					<h2>Current Moderators</h2>
					 <table class="moderator-table w3-center w3-border w3-table-all w3-hoverable">
						<colgroup>
						   <col span="1" style="width: 45%;">
						   <col span="1" style="width: 45%;">
						   <col span="1" style="width: 10%;">
						</colgroup>
			
						<tr class="table_header">
							<th>Name</th>
							<th>Position</th>
							<th>Evidence</th>
						</tr>
						<?php
							$moderator_query = query_moderators_in($id);
							while ($expert_info = mysqli_fetch_assoc($moderator_query)){
								echo "<tr>";
								$moderator_user_id = $expert_info["id"];
								$moderator_username = $expert_info["Username"];
								$moderator_credential = mysqli_fetch_assoc(
													query_user_credentials_in($moderator_user_id, $id));
								$moderator_credential_name = $moderator_credential["name"];
								$moderator_credential_url = $moderator_credential["evidence_file_dir"];
								
								echo "<td>$moderator_username</td>";
								echo "<td>$moderator_credential_name</td>";
								echo "<td><a href='$moderator_credential_url'>View</a></td>";
								echo "</tr>";
							}
						?>
					 </table>
				 </div>
			</div>
			<div id="credential-approval" class=" w3-container w3-center center">
				<h2>Pending Credentials</h2>
					 <table class="credential-table w3-table-all w3-hoverable">
						<colgroup>
						   <col span="1" style="width: 45%;">
						   <col span="1" style="width: 35%;">
						   <col span="1" style="width: 10%;">
						   <col span="1" style="width: 10%;">
						</colgroup>
			
						<tr class="table_header">
							<th>Name</th>
							<th>Position</th>
							<th>Evidence</th>
							<th>Action</th>
						</tr>
						<?php
							$pending_cred_query = query_pending_credentials_from($id);
							while ($pending_cred = mysqli_fetch_assoc($pending_cred_query)){
								echo "<tr>";
								$cred_user_id = $pending_cred["UserID"];
								$cred_username = $pending_cred["Username"];
								$cred_url = $pending_cred["Evidence"];
								$cred_name = $pending_cred["Credential"];
								$cred_id = $pending_cred["credentialID"];
								
							
								echo "<td>$cred_username</td>";
								echo "<td>$cred_name</td>";
								echo "<td><a href='$cred_url'>View</a></td>";
								echo "<td><a href='moderator/moderator_credential_action.php?
											action=APPROVED&categoryID=$id&userID=$cred_user_id&credentialID=$cred_id'>Approve</a><br/>
										   <a href='moderator/moderator_credential_action.php?
											action=REJECTED&categoryID=$id&userID=$cred_user_id&credentialID=$cred_id'>Reject</a></td>";
								//TODO: Insert URL to action
							}
						?>
					 </table>
			</div>
		</div>
		<?php include 'footer.php' ?>

	</body>


</html>