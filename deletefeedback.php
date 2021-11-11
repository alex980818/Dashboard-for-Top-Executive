
<?php 
require_once "config.php";
    
    
$conn = new mysqli('localhost', 'justforl_projectadmin', 'JxNB&sx$SP*x', 'justforl_project');
$feedbids = $_GET['feedbids'];

$sqldelete = "DELETE FROM FEEDBACK WHERE FEEDBID='$feedbids'";


if ($conn->query($sqldelete) === TRUE){
       echo "<script>alert('Feedback Deleted Sucessful!');window.location.href='feedbackhistory.php';</script>";
}else {
       echo "failed";
}
                             


?>