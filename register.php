<?php
// Include config file
require_once "config.php";


 
// Define variables and initialize with empty values
$email = $name = $password = $confirm_password = $phone = "";
$email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT ID FROM USERS WHERE EMAIL = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already registered!";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
    }
    
    
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $code = trim($_POST["code"]);
    $code2 = 0;
    $tnc = 0;
    
    //Validate comfirm specific code
    if(empty(trim($_POST["code"] ))){
        $code_err = "Please enter a code.";
    } else{
        if(trim($_POST["code"]) != 12345){
         $code_err = "Invalid Specific code";
    }   else{
        $code2=1;
        
    }
    }
    

    

    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err) && $code2===1 ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO USERS (EMAIL, PASSWORD, NAME, PHONE, VERIFY) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_email, $param_password, $param_name, $param_phone, $param_verify);
            
            // Set parameters
            $param_email = $email;
            // Creates a password hash
            $param_password = password_hash($password, PASSWORD_DEFAULT); 
            // $param_password = $password;
            $param_name = $name;
            $param_phone = $phone;
            $param_verify = 0;
           
            // sendEmail($email);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                // echo "<script>alert('Register sucessful!');window.location.href='login.php';</script>";
                $_SESSION["email"] =$email;

                echo "<script>alert('Register sucessful!');window.location.href='PHPMailer/sendVerifyEmail.php?email=$email';</script>";
                // echo "<script>alert('Register sucessful!');window.location.href='sendEmail.php?email=$email';</script>";
            } else{
                echo "Something went wrong. Please try again later.";
                 echo $email;
                 echo $password;
                 echo $name;
                 echo $phone;
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
  border: 2px solid #696969;;
}

.button1:hover {
  background-color: #241E1E;
  color: white;
}

}
@viewport{
    zoom:1.0;
    width: extend-to-zoom;
}
@-ms-viewport{
    width: extend-to-zoom;
    zoom: 1.0;
} 
</style>
<script>
 function sendEmail($email) {
        $to = "$email";
        $subject = "Verification for Dashboard";
        $txt = "http://justforlhdb.com/project/verify.php?email=.$email";
        $headers = "From: noreply@dashboard.com" . "\r\n" .
        "CC: somebodyelse@example.com";

mail($to,$subject,$txt,$headers);

    // $to      = $email; 
    // $subject = 'Verification for Dashboard'; 
    // $message = 'http://justforlhdb.com/project/verify.php?email='.$email; 
    // $headers = 'From: noreply@dashboard.com' . "\r\n" . 
    // 'Reply-To: '.$email . "\r\n" . 
    // 'X-Mailer: PHP/' . phpversion(); 
    // mail($to, $subject, $message, $headers); 
     
 }
</script>


<script>
    // When the user clicks on div, open the popup
    function myFunction() {
     var popup = document.getElementById("myPopup");
     popup.classList.toggle("show");
    }
    
   
</script>

</head>
<link rel="stylesheet" type="text/css" href="tnc.css">
<meta name="viewport" content="width=device-wodth, initial-scale=1">
<body style="background-color:#241E1E;">
    <h1> <br> </h1>
    <div class="card"> 
    <div class="wrapper">
        <h1>Register</h1>
        Please fill this form to create an account.<br>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required value="<?php echo $name; ?>">
            </div> 
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required value="<?php echo $phone; ?>">
            </div> 
            <div class="form-group <?php echo (!empty($code_err)) ? 'has-error' : ''; ?>">
                <label>Code</label>
                <input type="password" name="code" class="form-control" required value="<?php echo $code; ?>">
                <span class="help-block"><?php echo $code_err; ?></span>
            </div >
            <div class="popup" onclick="myFunction()">
            <div class="form-group <?php echo (!empty($tnc_err)) ? 'has-error' : ''; ?>">
            <input type="checkbox" required name="checkbox" value="check" id="agree"/> I have read and agree to the Terms and Conditions and Privacy Policy
            <span class="popuptext" id="myPopup">This End-User License Agreement is a legal agreement between you and justforlhdb.Please read this EULA agreement carefully before using the dashboard. It provides a license to use the dashboard and contains warranty information and liability disclaimers.By clicking accept or, you are confirming your acceptance of the dashboard and agreeing to become bound by the terms of this EULA agreement. The Software (and the copyright, and other intellectual property rights of whatever nature in the dashboard, including any modifications made thereto) are and shall remain the property of justforlhdb. 
  
            </div>
            </div>
            </div> 
           
            
            <div class="form-group">
                <input type="submit" class="button button1" value="Register">
                <input type="reset" class="button button1" value="Reset">
            </div>
            
        </form>
    </div>    </div>
    
</body>
</html>