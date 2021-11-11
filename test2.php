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
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!------------------Number of Product Sales-------------------------------->
    <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart2);
    
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
    
    function drawChart2() {
      var data = google.visualization.arrayToDataTable([
        ["Product", "Quantity" ],
        ["Product A", 1000],
        ["Product B", 1100],
        ["Product C", 1350],
        ["Product D", 1200],
        ["Product E", 1350]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }
                       ]);

      var options = {
        title: "Number of Product Sales",
        'width':'100%',
        'height':'100%',
        // height: 350,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var options2 = {
        title: "Number of Productivity Product",
        // 'width':'100%',
        // height: 350,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var options3 = {
        title: "Cost of Productivity Product",
        // 'width':'100%',
        // height: 350,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
      
    //   var chart2 = new google.visualization.ColumnChart(document.getElementById("columnchart_values2"));
    //   chart2.draw(view, options2);
      
    //   var chart3 = new google.visualization.ColumnChart(document.getElementById("columnchart_values3"));
    //   chart3.draw(view, options3);
      

  }
  
        
		
  $(window).resize(function(){
            drawChart2();
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

 

       <div id="columnchart_values" style="width: 100%; height: 100%;">
   
      
				    
			
  

    
</body>
</html>