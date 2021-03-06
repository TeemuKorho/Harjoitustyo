<?php
require_once "config.php";
 
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
    if(empty(trim($_POST["username"])))
	{
        $username_err = "Syötä käyttäjätunnus.";
    }
	else
	{
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql))
		{
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($stmt))
			{
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1)
				{
                    $username_err = "Käyttäjätunnus on jo olemassa.";
                } 
				else
				{
                    $username = trim($_POST["username"]);
                }
            } 
			else
			{
                echo "Jokin meni vikaan. Yritä myöhemmin uudelleen.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    if(empty(trim($_POST["password"])))
	{
        $password_err = "Syötä salasana.";     
    } 
	elseif(strlen(trim($_POST["password"])) < 6)
	{
        $password_err = "Salasanassa on oltava vähintään 6 merkkiä.";
    } 
	else
	{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"])))
	{
        $confirm_password_err = "Syötä salasana uudelleen.";     
    } 
	else
	{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password))
		{
            $confirm_password_err = "Salasana ei täsmää.";
        }
    }
    
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
	{        
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql))
		{
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            
            if(mysqli_stmt_execute($stmt))
			{
                header("location: login.php");
            } 
			else
			{
                echo "Jokin meni vikaan. Yritä myöhemmin uudelleen.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekisteröityminen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body
		{ 
			font: 14px sans-serif; 
		}
        .wrapper
		{ 
			width: 350px; 
			padding: 20px;
			height: 200px;
			width: 400px;
			
			position: fixed;
			left: 50%;
			margin-top: 200px;
			margin-left: -200px;
		}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Tunnuksen luominen</h2>
        <p>Luo tunnus täyttämällä tiedot.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Käyttäjätunnus</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Salasana</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Salasana uudelleen</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Luo tunnus">
                <input type="reset" class="btn btn-default" value="Resetoi">
            </div>
            <p>Joko sinulla on tunnus? <a href="login.php">Kirjaudu sisään tästä.</a>.</p>
        </form>
    </div>    
</body>
</html>