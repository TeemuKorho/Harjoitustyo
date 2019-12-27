<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Pääsivu</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="grid-container">
	<div class="item1">Uutisia</div>
	
	<div class="item2">
	<a href="logout.php">Kirjaudu ulos</a></div>
	
	<div class="item3">
	<?php include("uutiset.php"); ?></div>
	
	<div class="item4">Copyright by nobody</div>
</div>
</body>
</html>