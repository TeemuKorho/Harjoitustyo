<?php
session_start();
 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}
 
require_once "config.php";
 
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST")
{ 
    if(empty(trim($_POST["new_password"])))
	{
        $new_password_err = "Syötä uusi salasana.";     
    } 
	elseif(strlen(trim($_POST["new_password"])) < 6)
	{
        $new_password_err = "Salasanassa on oltava vähintään 6 merkkiä.";
    } 
	else
	{
        $new_password = trim($_POST["new_password"]);
    }
    
    if(empty(trim($_POST["confirm_password"])))
	{
        $confirm_password_err = "Varmista salasana.";
    } 
	else
	{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password))
		{
            $confirm_password_err = "Syöttämäsi salasana ei vastannut uutta salasanaa. Yritä uudelleen.";
        }
    }

    if(empty($new_password_err) && empty($confirm_password_err))
	{
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql))
		{
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            if(mysqli_stmt_execute($stmt))
			{
                session_destroy();
                header("location: login.php");
                exit();
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
    <title>Salasanan resetointi</title>
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
		}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Resetoi salasana</h2>
        <p>Täytä formi laittaaksesi uuden salasanan.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>Uusi salasana</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Varmista salasana</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="login.php">Keskeytä</a>
            </div>
        </form>
    </div>    
</body>
</html>