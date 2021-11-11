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

            
            $sqladd = "INSERT INTO FEEDBACK (ID, TITLE, COMMENT) VALUES ('$id', '$title', '$comment')";
            if($stmt = mysqli_prepare($link, $sqladd)){
                mysqli_stmt_bind_param($stmt, "sss", $id, $param_title, $param_comment);
                $param_id = $id;
                $param_title = $title;
                $param_comment = $comment;
                
                
            }
                
                $valid = 1;
        }
        

        
        if ($valid===0){
            echo "Updated Failed";
                  
        }else if ($valid===1){
                 if(mysqli_stmt_execute($stmt)){
                        // Redirect to login page
                        echo "<script>alert('Feedback Added Sucessful!');window.location.href='feedbackhistory.php';</script>";
                    	
                 
        } 
                
                    
                    mysqli_stmt_close($stmt);
            }else echo"fail";

$conn->close();

?>