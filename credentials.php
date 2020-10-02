<html>
	<head>
		
		<?php include 'header.php'; 
			$current_user = get_login_user();
			$current_user_id = $current_user["id"];
		?>
		
		<title>My Credentials</title>
	
	</head>
	<body>
		
		<div id="credentials" class="w3-border credentials w3-container w3-center center">
			<div class="w3-orange w3-border"><h1>My Credentials</h1></div>
			<hr/>
			<?php
				$categories_query = query_categories();
				while ($category = mysqli_fetch_assoc($categories_query)){
					$category_name = $category["name"];
					$category_id = $category["id"];
					echo "<h2>$category_name</h2>";
					include "templates/credentials_table_template.php";
				}
			?>
		</div>
		<div id="add_credentials" class="w3-border w3-panel w3-center center w3-twothirds">
			<h2>Add Credential</h2>
			<form id="credential_form" enctype="multipart/form-data" method="POST" action="credential_script.php">
				<div class="credentials w3-center w3-border w3-topbar w3-bottombar">
					<h3>Step 1: Specify Title or Background</h3><br/>
					<!--Start select-->
					<div class="title-section">
						<div class="w3-container w3-border select-mode w3-red">
							<b><p>Pick one</p></b>
							<input type="radio" class="w3-input w3-border" name="credential_insert_method" value="select"/>
							<select name="credential_id" form="credential_form" class="w3-input w3-border">
								<?php
									$categories_query= query_categories();
									while ($category = mysqli_fetch_assoc($categories_query)){

										$category_name = $category["name"];
										$category_id = $category["id"];
										echo "<optgroup label='$category_name'>";
										$credential_id_query = query_credential_ids_from($category_id);
										while ($credential = mysqli_fetch_assoc($credential_id_query)){
											$credential_id = $credential["id"];
											$credential_name = $credential["name"];
											echo "<option value='$credential_id'>$credential_name</option>";
										}
										echo "</optgroup>";
									}
								?>
							</select><br>
						</div>
						<!--End select-->
						-or- 
						<br/>
						<!--Start manual-->
						<div class="w3-container w3-border select-mode w3-blue">
							<b><p>Create one</p></b>

							<input type="radio" class="w3-input" name="credential_insert_method" value="manual"/><br/>
							<input class="w3-input w3-border w3-border-blue" type="text" name="credential_name" placeholder="Title"/><br/>
							<label for="category_id">Category</label>
							<select placeholder="Category" 
									name="category_id" form="credential_form" class="w3-input">
								<?php
									$categories_query = query_categories();
									while ($category = mysqli_fetch_assoc($categories_query)){
										$category_name = $category["name"];
										$category_id = $category["id"];
										echo "<option value='$category_id'>$category_name</option>";
									}
									?>
							</select><br>
						</div>
						<!--End Manual-->
					</div>
				</div>
				<div class="credentials w3-center center w3-border w3-topbar w3-bottombar">
					
					<h3>Step 2: Submit Evidence</h3><br/>
					<div class="upload w3-green">
						<b><p>Upload</p></b>
						<input class="w3-input" type="radio" name="evidence_method" value="upload"><br>
						<input class="w3-input w3-white w3-border w3-center" type="file" name="evidence_file" id="evidence_file"/>
						<br/>
						<br/>
					</div>
	
					-or-
					<br/>
					<div class="url w3-yellow">
						<b><p>Link</p></b>

						<input type="radio" name="evidence_method" value="url"><br>
						<label  for="evidence_url">URL</label>
						<input class="w3-input w3-border" type="url" name="evidence_url"/><br/>
						<input type="submit" name="submit_evidence"/>
					</div>
				</div>
			</form>
		</div>
		<?php include 'footer.php' ?>
	</body>

</html>