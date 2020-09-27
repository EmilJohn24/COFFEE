<?php
	setcookie("SESSION_ID", $_COOKIE["SESSION_ID"], time() - 3600, "/");
	header("Location: index.php");
?>