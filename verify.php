<?php
// Create connection
$conn = new mysqli('localhost', 'justforl_projectadmin', 'JxNB&sx$SP*x', 'justforl_project');

$email = $_GET['email'];
// $name="bbbb";
$id=70;
$verify=1;


    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "UPDATE USERS SET VERIFY='$verify' WHERE EMAIL='$email'";
    
    if ($conn->query($sql) === TRUE) {
      echo "<script>alert('Verified Successfully');window.location.href='login.php';</script>";
    } else {
      echo "Error updating record: " . $conn->error;
    }
    
    $conn->close();

        

?>