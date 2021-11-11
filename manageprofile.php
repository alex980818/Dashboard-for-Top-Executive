<?php
// Include config file
require_once "config.php";
session_start();
$id = $_SESSION['id'];
$valid = 0;

 $conn = new mysqli('localhost', 'justforl_projectadmin', 'JxNB&sx$SP*x', 'justforl_project');
$id = $_SESSION["id"];
$sql = "SELECT * FROM USERS";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
      if($_SESSION["id"] == $row["ID"]){
        $name = $row["NAME"];
        $phone = $row["PHONE"];
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
    <title>Manage Profile</title>
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


</head>
<link rel="stylesheet" type="text/css" href="tnc.css">
<meta name="viewport" content="width=device-wodth, initial-scale=1">
<body style="background-color:#241E1E;">
    <h1> <br> </h1>
    <div class="card"> 
    <div class="wrapper">
        <h1>Manage Profile</h1>
        <br>
        
        
        <div><form action="updateprofile.php" method="post">
 			<label for="email">Email:</label>
  			<input type="email" name="email" class="form-control" placeholder="<?php echo $_SESSION['email']?>"  readonly="true"">
  			<br>
   			
			<label for="name">Name:</label>
  			<input type="text" name="name" id="name" class="form-control" placeholder="<?php echo $name?>" ">
  			<br>
  			
			<label for="phone">Phone:</label>
  			<input type="text" name="phone" id="phone" class="form-control" placeholder="<?php echo $phone?>" ">
  			<br>
	
            
            
            </div> 
           
            
            <div class="form-group">
                <input type="submit" class="button button1" value="Update">
                <input type="reset" class="button button1" value="Reset">
            </div>
            <p><a href="dash.php" style="color:darkblue;">Back to Dashboard</a></p>
            
        </form>
    </div>    </div>
    
</body>
</html>