<?php
// Include config file
require_once "config.php";
session_start();
$id = $_SESSION['id'];
$feedbid = $_GET['feedbids'];
$valid = 0;

 $conn = new mysqli('localhost', 'justforl_projectadmin', 'JxNB&sx$SP*x', 'justforl_project');
$id = $_SESSION["id"];
$sql = "SELECT * FROM FEEDBACK WHERE FEEDBID = '$feedbid'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
      if($_SESSION["id"] == $row["ID"]){
        $date = $row["DATE"];
        $title = $row["TITLE"];
        $comment = $row["COMMENT"];
      }
  }
} else {
  echo "Error";
}

 
        

?>


 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Feedback</title>
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
}

.button1 {
  background-color: white; 
  color: black; 
  border: 2px solid #0000A0;
}

.button1:hover {
  background-color: #0000A0;
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
var d = new Date();
document.getElementById("demo").innerHTML = d;
</script>


</head>
<link rel="stylesheet" type="text/css" href="tnc.css">
<meta name="viewport" content="width=device-wodth, initial-scale=1">
<body style="background-color:#0000A0;">
    <h1> <br> </h1>
    <div class="card"> 
    <div class="wrapper">
        <h1>Edit Feedback</h1>
        <br>
        
        <a href="updatefeedback.php?data=<?=$feedbid?>"></a>
        <div><form action="updatefeedback.php" method="post">
 			<label for="date">Date:</label>
  			<input type="text" name="date" class="form-control" style="text-align: center" readonly="true"
  			placeholder="<?php echo $date ?>">
  			<br>
   			
			<label for="title">Title:</label>
  			<input type="text" name="title" id="title" class="form-control" placeholder="<?php echo $title?>" ">
  			<br>
  			
			<label for="comment">Comment:</label>
  			<input type="text" name="comment" id="comment"  class="form-control" placeholder="<?php echo $comment?>"">
  			
        </div> 
        <div style="display: flex; justify-content: flex-end">
            <p><a href="feedbackhistory.php">Feedback History</a></p>
        </div>
           
            
        <div class="form-group">
            <input type="hidden" name="feedbid" value="<?php echo $feedbid?>">
            <input type="submit" class="button button1" value="Save"">
            <input type="reset" class="button button1" value="Reset">
        </div>
        <p><a href="dash.php">Back to Dashboard</a></p>    
            
        </form>
    </div>    </div>
    
</body>
</html>