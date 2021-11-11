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
        
        $date = $row["DATE"];
        $title = $row["TITLE"];
        $comment = $row["COMMENT"];
      
  }
} else {
  echo "Error";
}

//Data for Top 5 Product
$sql2 = "SELECT PRODUCT, RM FROM PRODUCTS"; 
$result2 = mysqli_query($conn, $sql2); 
 
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <!------------------Top 5 Chart-------------------------------------------->
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
    
          var jsondata;
          $.ajax({
              'async': false,
              'type': "GET",
              'dataType': 'json',
              'url': "db.php",

              'success': function (data) {
                         jsondata = data;

              }
          });
      
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        //   ['Product', 'RM'],
        //   ['Product A', 1000],
        //   ['Product B', 1170],
        //   ['Product C', 660],
        //   ['Product D', 1030],
        //   ['Product E', 1030]
        ['Product', 'RM'],
         
        <?php  
                          while($row = mysqli_fetch_array($result2))  
                          {  
                               echo "['".$row["PRODUCT"]."', ".$row["RM"]."],";  
                          }  
                          ?> 
         ]);

        var options = {
          chart: {
            title: 'Profit for Top-5 Products',
            // subtitle: 'Sales, Expenses, and Profit: 2014-2017',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
        
      }
      
   
      
      $(window).resize(function(){
            drawChart();
		});
      
    </script>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <style type="text/css">

</style>


</head>
<link rel="stylesheet" type="text/css" href="tnc.css">
<meta name="viewport" content="width=device-wodth, initial-scale=1">
<!--<body style="background-color:#0000A0;">-->

 

       <div id="barchart_material" style="width: 100%; height: 100%;">
   
      
				    
			
  

    
</body>
</html>