<?php
//session_start();
error_reporting (E_ALL ^ E_NOTICE);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Pääsivu</title>
	<link rel="stylesheet" href="tyyli.css">
</head>

<body>

<div class="grid-container">
	<div class="item1">Puuta Heinää Uutisia</div>
	
	<div class="item2">
	Kirjautuminen: <br>
	<form method="post" action="paasivu.php">
	Käyttäjätunnus: <input type="text" name="tunnus"></input><br>
	Salasana: <input type="password" name="salasana"></input><br>
	<button type="submit">Kirjaudu</button>
	</div>
	
	<div class="item3">
	<?php
	$uname = $_POST["tunnus"];
	$pw = $_POST["salasana"];
	
	if (!isset($uname) && !isset($pw))
	{
		echo "Tämän sivun uutiset näkyvät ainoastaan kirjautuneille käyttäjille :(";
	}
	else if (isset($uname) && isset($pw))
	{
		echo "Käyttäjä kirjautunut. Näytetään uutiset";
	}
	
	?>
	</div>
	
	<div class="item4">Copyright pending</div>
</div>

</body>
</html>