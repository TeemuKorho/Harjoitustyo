<!DOCTYPE html>
<html>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kayttaja";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT Nimi, Salasana, Tyyppi FROM kayttaja";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "id: " . $row["Nimi"]. " - Name: " . $row["Salasana"]. " " . $row["Tyyppi"]. "<br>";
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
</body>
</html>