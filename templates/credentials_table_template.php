<html>
	<body>
	<div class="credentials w3-panel">
			<table class="forum_table w3-border w3-hoverable w3-table w3-bordered">
			    <colgroup>
				   <col span="1" style="width: 70%;">
				   <col span="1" style="width: 20%;">
				   <col span="1" style="width: 10%;">
				</colgroup>
    
				<tr class="table_header">
					<th>Title</th>
					<th>Status</th>
					<th>Evidence</th>
				</tr>
				<?php
					$current_user_credential_query = query_user_credentials($current_user_id, $category_id);	
					while($credential = mysqli_fetch_assoc($current_user_credential_query)){
						$title = $credential["name"];
						$status = $credential["status"];
						$evidence_dir = $credential["evidence_file_dir"];
						echo "<tr class='table_content'>";
						echo "<td>$title</td>";
						echo "<td>$status</td>";
						echo "<td><a href='$evidence_dir'>View</a></td>";
						echo "</tr>";
					}
				?>
			</table>
		
		</div>
	
	
	</body>

</html>