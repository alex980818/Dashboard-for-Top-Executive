<?php

session_start();
include 'config.php';
$con = mysqli_connect("localhost", "justforl_projectadmin", "JxNB&sx$SP*x", "justforl_project");


$feedbid = $_POST['feedbid'];
$id = $_SESSION['id'];
$title = $_POST['title'];
$comment = $_POST['comment'];
$valid = 0;
       
        if(!empty($title) && !empty($comment)){

            $sqlupdate = "UPDATE FEEDBACK SET TITLE = '$title', COMMENT = '$comment' WHERE FEEDBID = '$feedbid'";
            
            if($stmt = mysqli_prepare($link, $sqlupdate)){
                mysqli_stmt_bind_param($stmt, "ss", $param_title, $param_comment);
                $param_title = $title;
                $param_comment = $comment;
                
                
            }
                
                $valid = 1;
        }
        
        if(!empty($title) && empty($comment)){

            $sqlupdate = "UPDATE FEEDBACK SET TITLE = '$title' WHERE FEEDBID = '$feedbid'";
            
            if($stmt = mysqli_prepare($link, $sqlupdate)){
                mysqli_stmt_bind_param($stmt, "s", $param_title);
                $param_title = $title;

                
            }
                
                $valid = 1;
        }
        
        if(empty($title) && !empty($comment)){

            $sqlupdate = "UPDATE FEEDBACK SET COMMENT = '$comment' WHERE FEEDBID = '$feedbid'";
            
            if($stmt = mysqli_prepare($link, $sqlupdate)){
                mysqli_stmt_bind_param($stmt, "s", $param_comment);
                $param_comment = $comment;
                
                
            }
                $valid = 1;
        }
        
        if ($valid===0){
            echo "Updated Failed";
                  
        }else if ($valid===1){
                 if(mysqli_stmt_execute($stmt)){
                        // Redirect to login page
                        echo "<script>alert('Feedback Updated Sucessful!');window.location.href='feedbackhistory.php';</script>";
                    	
                 
        } 
                
                    
                    mysqli_stmt_close($stmt);
            }else echo"fail";

$conn->close();

?>