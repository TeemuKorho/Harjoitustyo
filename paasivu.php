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
	<a href="logout.php" class="btn btn-danger">Kirjaudu ulos</a>
	</div>
	
	<div class="item3">
	<h1>Uutiset tulevat sitten tähän</h1>
	</div>
	
	<div class="item4">Copyright by nobody</div>
</div>
</body>
</html>