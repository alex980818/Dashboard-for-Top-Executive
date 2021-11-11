<?php

session_start();
include 'config.php';
$con = mysqli_connect("localhost", "justforl_projectadmin", "JxNB&sx$SP*x", "justforl_project");



$id = $_SESSION['id'];
$email = $_SESSION['email'];
$password = $_POST['password']; 
$newpassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT); 
$confirmpassword = $_POST['confirmpassword'];
$valid = 0;



        if(!empty($password) && !empty($newpassword) && !empty($confirmpassword)){
            
                            
            // $sqlupdate = "UPDATE USERS SET NAME ='$name' WHERE ID='$id'";
            
            $sql = "UPDATE USERS SET PASSWORD ='$newpassword' WHERE ID='$id' AND PASSWORD = '$password' ";
            
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_newpassword);
                $param_newpassword =  $newpassword; 
                 $valid=1;
               
                
            }

            
        }
        
        
        
        
        
        if ($valid===0)
        {
          echo 'Not inserted';
          echo "ID: ".$id;
          echo " Password: ".$password;
          echo " New Password: ".$newpassword;
          echo " Confirm Password: ".$confirmpassword;
          
        }
        else if ($valid===1){
         if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo "<script>alert('Password Updated sucessful!');window.location.href='dash.php';</script>";
                	
             
         }
            
                
                mysqli_stmt_close($stmt);
        }else echo"fail";

$conn->close();

?>