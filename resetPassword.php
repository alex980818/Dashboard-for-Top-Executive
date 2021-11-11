<?php
// Include config file
require_once "config.php";
$con = mysqli_connect("localhost", "justforl_projectadmin", "JxNB&sx$SP*x", "justforl_project");
session_start();
$id = $_SESSION['id'];
$email = $_GET['email'];
$_SESSION['email'] = $_GET['email'];

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate New Password
    if(strlen(trim($_POST["newpassword"])) < 6){
        $newpassword_err = "New password must have atleast 6 characters.";
    } else{
        $newpassword = $_POST['newpassword']; 
        $newpassword2 = password_hash($_POST['newpassword'], PASSWORD_DEFAULT); 
    }
    
     // Validate confirm password
     $confirmpassword = trim($_POST["confirmpassword"]);
    if(empty($password_err) && ($newpassword != $confirmpassword)){
            $con_password_err = "Password did not match."; 
    }else{
        $confirmpassword = trim($_POST["confirmpassword"]);
    }
    

    // Close connection
    mysqli_close($link);
}
        

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        .card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 350px;
  margin: auto;
  text-align: center;
  font-family: arial;
  background-color: white;
  border-radius: 15px 15px;}
.button {
  border: 2px solid #0000A0;
  color: black;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  border-radius: 15px 15px;
}

.button1 {
  background-color: #dddddd; 
  color: black; 
  border: 2px solid #696969;
}

.button1:hover {
  background-color: #241E1E;
  color: white;
}

@viewport{
    zoom:1.0;
    width: extend-to-zoom;
}
@-ms-viewport{
    width: extend-to-zoom;
    zoom: 1.0;
} 

}
</style>


</head>
<link rel="stylesheet" type="text/css" href="tnc.css">
<meta name="viewport" content="width=device-wodth, initial-scale=1">
<body style="background-color:#241E1E;">
    <h1> <br> </h1>
    <div class="card"> 
    <div class="wrapper">
        <h1>Reset Password</h1>
        <br>
        
        
            <form action="updateResetPassword.php" method="post">
                
                
			<div class="form-group <?php echo (!empty($newpassword_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="newpassword" class="form-control" required value="<?php echo $newpassword; ?>">
                <span class="help-block"><?php echo $newpassword_err; ?></span>
            </div>
            
            <div class="form-group <?php echo (!empty($con_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" class="form-control" required value="<?php echo $confirmpassword; ?>">
                <span class="help-block"><?php echo $con_password_err; ?></span>
            </div> 
  			
			
	
            
            
            </div> 
           
            
            <div class="form-group">
                <input type="submit" class="button button1" value="Update">
                <input type="reset" class="button button1" value="Reset">
            </div>
            
        
            
        </form>
    </div>    </div>
    
</body>
</html>