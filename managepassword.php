<?php
// Include config file
require_once "config.php";
$con = mysqli_connect("localhost", "justforl_projectadmin", "JxNB&sx$SP*x", "justforl_project");
session_start();
$id = $_SESSION['id'];


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $sql = "SELECT * FROM USERS WHERE ID = '$id'";
    // $password2 = "0";

    // Validate password
    if ($row['PASSWORD'] == $password){
        $password = trim($_POST["password"]);
        // $password = password_hash($password, PASSWORD_DEFAULT); 
        // $password2 = $row['PASSWORD'];
    }else{
        $password_err = "Please key in the correct password: ";
    }
    
 
    
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
    
    
// $conn = mysqli_connect("localhost", "justforl_webassign3admin", "2~j[ChHODb.q", "justforl_webassign3");

    // // Check connection
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    $getsql = "SELECT ID, PASSWORD FROM USERS WHERE ID='$id'";
    
    
    if($stmt = mysqli_prepare($link, $getsql)){

        mysqli_stmt_bind_param($stmt, "s", $param_id);
            
        // Set parameters
        $param_id = $id;
        
        // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){ 

                    mysqli_stmt_bind_result($stmt, $id2, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)){
                       
                        if(password_verify($password, $hashed_password)){
                            
                             session_start();
                            
                            // Store data in session variables
                            $_SESSION["$hashed_password"] = $hashed_password;
                            $_SESSION["id2"] = $id2;
                            echo nl2br("success\n");
                            $sql = "UPDATE USERS SET PASSWORD ='$newpassword2' WHERE ID='$id'";
            
                            if($stmt = mysqli_prepare($link, $sql)){
                                mysqli_stmt_bind_param($stmt, "s", $param_newpassword);
                                $param_newpassword =  $newpassword; 
                                
                                if(mysqli_stmt_execute($stmt)){
                                // Redirect to login page
                                echo "<script>alert('Password Updated sucessful!');window.location.href='dash.php';</script>";
                                	
                             
                                }else{
                                 echo "<script>alert('Password Updated Fail!');";
                                }  
                                
                            }else{
                                echo "Something went wrong. Please try again later.";
                                 
                                 echo $password;
                                 echo $newpassword;
                                 echo $confirmpassword;
                            }
                        }else{
                            // Display an error message if email doesn't exist
                            $password_err = "Wrong password";
                        }
                        
                    }
                    
                }
                
            }
    }

//     $result = $conn->query($getsql);
    
//     if ($result->num_rows > 0) {
//       // output data of each row
//       while($row = $result->fetch_assoc()) {
        
//         $password2 = $row["PASSWORD"];
//       }
//     } else {
//       echo "Error";
//     }
//         $password2 = $row["PASSWORD"];

//     // Check input errors before inserting in database
//       if(!empty($password) && !empty($newpassword) && !empty($confirmpassword)){
//             // if (password_verify($password, $password2)) {
                            
//             // $sqlupdate = "UPDATE USERS SET NAME ='$name' WHERE ID='$id'";
            
//             echo nl2br("\nid: ".$id."\n");
//             echo nl2br("password: ".$password."\n");
//             echo nl2br("password2: ".$password2."\n");
            
//             $sql = "UPDATE USERS SET PASSWORD ='$newpassword2' WHERE ID='$id'";
            
//             if($stmt = mysqli_prepare($link, $sql)){
//                 mysqli_stmt_bind_param($stmt, "s", $param_newpassword);
//                 $param_newpassword =  $newpassword; 
                
//                 if(mysqli_stmt_execute($stmt)){
//                 // Redirect to login page
//                 // echo "<script>alert('Password Updated sucessful!');window.location.href='dash.php';</script>";
                	
             
//                 }else{
//                  echo "<script>alert('Password Updated Fail!');";
//                 }  
                
//             }else{
//                 echo "Something went wrong. Please try again later.";
                 
//                  echo $password;
//                  echo $newpassword;
//                  echo $confirmpassword;
//             }
// // }else{
// //         $password_err = "Please insert the correct password. ".$password2."hi";
// //     }
            
//         }else{
//                 echo "<script>alert('Password Updated fail!');</script>";
                 
                 
//             }

    // Close connection
    mysqli_close($link);
}
        

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Password</title>
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
        <h1>Manage Password</h1>
        <br>
        
        
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                
 			<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required value="">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
   			
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
            <p><a href="dash.php">Back to Dashboard</a></p>
        </form>
    </div>    </div>
    
</body>
</html>