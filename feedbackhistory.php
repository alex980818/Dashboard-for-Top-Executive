<?php
// Include config file
require_once "config.php";
session_start();
$id = $_SESSION['id'];
$valid = 0;

 $conn = new mysqli('localhost', 'justforl_projectadmin', 'JxNB&sx$SP*x', 'justforl_project');
$id = $_SESSION["id"];
$sql = "SELECT * FROM FEEDBACK";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
        $feedbid = $row["FEEDBID"];
        $date = $row["DATE"];
        $title = $row["TITLE"];
        $comment = $row["COMMENT"];
      
  }
}
        

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Note History</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        
        .card {
          box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
          width: 60%;
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
  float: right;
  color: black; 
  border: 2px solid #0000A0;
}

.button1:hover {
  background-color: #0000A0;
  color: white;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  text-align: center;
  
  padding: 0px 3px 0px 3px;
  /*white-space: nowrap;*/
}
#myTable {
    width:80%;
}
#myTable tr td {
  border: 1px solid #000;
  padding: 0px 3px ;
  
}

#myTable tr td:first-child {
  max-width: 100px;
  width: 16%;
  overflow: hidden;
}
#myTable tr td:nth-child(2) {
  max-width: 200px;
  width: 25%;
  overflow: hidden;
}
#myTable tr td:nth-child(3) {
  max-width: 200px;
  width: 35%;
  overflow: hidden;
}
#myTable tr td:nth-child(4) {
  max-width: 200px;
  width: 12%;
  overflow: hidden;
}
#myTable tr td:last-child {
  max-width: 300px;
  width: 12%;
  overflow: hidden;
}

@viewport{
    zoom:1.0;
    width: extend-to-zoom;
}
@-ms-viewport{
    width: extend-to-zoom;
    zoom: 1.0;
} 

@media screen and (max-width: 900px){
    .card{
        width: 95%;
    }
    
    #myTable {
    width:95%;
    }
    #myTable tr td:first-child {
  /*max-width: 100px;*/
  width: 16%;
  overflow: hidden;
}
#myTable tr td:nth-child(2) {
  /*max-width: 200px;*/
  width: 25%;
  overflow: hidden;
}
#myTable tr td:nth-child(3) {
  /*max-width: 200px;*/
  width: 35%;
  overflow: hidden;
}
#myTable tr td:nth-child(4) {
  /*max-width: 200px;*/
  width: 12%;
  overflow: hidden;
}
#myTable tr td:last-child {
  /*max-width: 300px;*/
  width: 12%;
  overflow: hidden;
}
}
</style>
<script>
function deleletconfig(){

var del=confirm("Are you sure you want to delete this record?");
if (del==true){
   
}
return del;
}
</script>

</head>
<link rel="stylesheet" type="text/css" href="tnc.css">
<meta name="viewport" content="width=device-wodth, initial-scale=1">
<body style="background-color:#241E1E;">
    <h1> <br> </h1>
    <div class="card"> 

        <h1>Note History</h1>
        <br>
   
        <table id="myTable" align="center" >
				
					<t>
						<th>Date</th>				
						<th>Title</th>
						<th>Comment</th>
				
						<th>Edit Feedback</th>
						<th>Delete Feedback</th>
					
					</t>
					
					<?php
    					$sql = "SELECT * FROM FEEDBACK WHERE ID ='$id' ORDER BY DATE DESC ";
                        $result = $conn->query($sql);
					      if ($result->num_rows > 0) {
                          // output data of each row
                          while($row = $result->fetch_assoc()) {
                               
                                $date = $row["DATE"];
                                $title = $row["TITLE"];
                                $comment = $row["COMMENT"];
                                $feedbid = $row["FEEDBID"];
                    ?>          
                                <tr>
                                <td><?php echo $date; ?></td>
        						<td><?php echo $title; ?></td>
        						<td><?php echo $comment; ?></td>
        						
        						<td><a href="editfeedback.php?feedbids=<?php echo $feedbid; ?>">Edit</a></td>
        						<td><a href="deletefeedback.php?feedbids=<?php echo $feedbid; ?>" onClick="return deleletconfig()">Delete</a></td>
        						<!--<td><a href onclick="deletefeedback()">Delete</a></td>-->

        						</tr>
        						
                    <?php          
                          }
                        } 
					?>
				    
				    </table>
				    <br>
				    <p style= "text-align:right; padding-right: 10%;";><a href="feedback.php">Add a new feedback</a></p>
                    <br>
				    <p><a href="dash.php">Back to Dashboard</a></p>
				    <br>
				    
			
        
    </div>    

    
</body>
</html>