<?php

session_start();
include 'config.php';
$con = mysqli_connect("localhost", "justforl_projectadmin", "JxNB&sx$SP*x", "justforl_project");



$id = $_SESSION['id'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$valid = 0;



        if(!empty($name) && empty($phone)){
            
            // $sqlupdate = "UPDATE USERS SET NAME ='$name' WHERE ID='$id'";
            
            $sql = "UPDATE USERS SET NAME ='$name' WHERE ID='$id'";
            
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_name);
                $param_name = $name;
                
               
                
            }

            $valid=1;
        }
        
        if(!empty($phone) && empty($name)){
            
            $sql = "UPDATE USERS SET PHONE ='$phone' WHERE ID='$id'";
            
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "s", $param_phone);
                $param_phone = $phone;
                
                
                
            }
            $valid = 1;
        }
        
        if(!empty($phone) && !empty($name)){
            
            $sql = "UPDATE USERS SET NAME = '$name', PHONE ='$phone' WHERE ID='$id'";
            
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "ss", $param_name, $param_phone);
                $param_name = $name;
                $param_phone = $phone;
                
                
            }
            $valid = 1;
        }
        
        
        if ($valid===0)
        {
          echo 'Not inserted';
          echo $name;
          echo $id;
          echo $phone;
        }
        else if ($valid===1){
         if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo "<script>alert('Profile Updated Sucessful!');window.location.href='dash.php';</script>";
                	
             
         }
            
                
                mysqli_stmt_close($stmt);
        }else echo"fail";

$conn->close();

?>