<?php
// Include config file
require_once "config.php";
session_start();
$id = $_SESSION['id'];
$dateOption = $_SESSION["dateOption"];
$valid = 0;

 $conn = new mysqli('localhost', 'justforl_projectadmin', 'JxNB&sx$SP*x', 'justforl_project');
 
 
// Get Latest Date
$sqlDate = "SELECT MAX(DATE) AS MAXDATE, MONTH(MAX(DATE)) AS MAXMONTH, YEAR(MAX(DATE)) AS MAXYEAR FROM PRODUCTS";
$result0 = mysqli_query($conn, $sqlDate);
        
    while($row = mysqli_fetch_array($result0)){  
         $maxd = $row["MAXDATE"];
         $maxm = $row["MAXMONTH"];
         $maxy = $row["MAXYEAR"];
         $lastY = $row["MAXYEAR"]-1;
         $lastM = $row["MAXMONTH"] +1;
    }
// echo "  MAxDate= ".$maxd;
// echo "  MAxMonth= ".$maxm;
// echo "  MAxYear= ".$maxy;

// $test = array("1","2","3","4","5");
// $testlength=count($test);

// for($i=0;$i<$testlength;$i++){
//     echo $i." = ".$test[$i]." ";
// }

// echo "date:  ".$dateOption;

//-----------------------------------------------------------------------------
//Data for Top 5 Product
// By Pass 7 day
// $sql = "SELECT DATE, PRODUCT, RM FROM TOP5_PRODUCT WHERE DATE >= DATE_SUB('2021-04-03', INTERVAL 7 DAY)";

// $sql0 = "SELECT DATE, PRODUCT FROM TOP5_PRODUCT";

// $result = mysqli_query($conn, $sql);

// $totalA = 0;
// $totalB = 0;
// $totalC = 0;

// while($row = mysqli_fetch_array($result))  
// {  
//     if($row["PRODUCT"] =='A'){
//         $totalA = $totalA + $row["RM"];
//     }else if($row["PRODUCT"] =='B'){
//         $totalB = $totalB + $row["RM"];
//     }else if($row["PRODUCT"] =='C'){
//         $totalC = $totalC + $row["RM"];
//     }
    
//     // echo "['".$row["PRODUCT"]."', ".$row["RM"]."],";  
// } 
//----------------------------------------------------------------------------
 
//-----------------------------------------------------------------------------
// Data for Top 5 Product
// By Today
    if($dateOption=="today"){
        
        $sql = "SELECT * FROM PRODUCTS WHERE DATE >= DATE_SUB('$maxd', INTERVAL 0 DAY)";
        $result = mysqli_query($conn, $sql);
        
        $totalA = 0;
        $totalB = 0;
        $totalC = 0;
        $totalD = 0;
        
        while($row = mysqli_fetch_array($result))  
        {  
            if($row["PRODUCT"] =='A'){
                $totalA = $totalA + $row["COST"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["COST"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["COST"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["COST"];
            }
            
            
        } 
    }else if($dateOption=="last7day"){
        $sql = "SELECT * FROM PRODUCTS WHERE DATE >= DATE_SUB('$maxd', INTERVAL 6 DAY)";
        
        $result = mysqli_query($conn, $sql);
        
        $totalA = 0;
        $totalB = 0;
        $totalC = 0;
        $totalD = 0;
        
        while($row = mysqli_fetch_array($result))  
        {  
            if($row["PRODUCT"] =='A'){
                $totalA = $totalA + $row["COST"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["COST"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["COST"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["COST"];
            }
            
            
        } 
    }else if($dateOption=="last30day"){ 
        $sql = "SELECT * FROM PRODUCTS WHERE DATE >= DATE_SUB('$maxd', INTERVAL 29 DAY)";
        
        $result = mysqli_query($conn, $sql);
        
        $totalA = 0;
        $totalB = 0;
        $totalC = 0;
        $totalD = 0;
        
        while($row = mysqli_fetch_array($result))  
        {  
            if($row["PRODUCT"] =='A'){
                $totalA = $totalA + $row["COST"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["COST"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["COST"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["COST"];
            }
            
            
        } 
    }else if ($dateOption=="last12month"){
        $sql = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN  '$lastY-$lastM-01' AND '$maxd'";
        
        $result = mysqli_query($conn, $sql);
        
        $totalA = 0;
        $totalB = 0;
        $totalC = 0;
        $totalD = 0;
        
        while($row = mysqli_fetch_array($result))  
        {  
            if($row["PRODUCT"] =='A'){
                $totalA = $totalA + $row["COST"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["COST"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["COST"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["COST"];
            }
            
            
        } 
    }else{
        $sql = "SELECT * FROM PRODUCTS WHERE DATE >= DATE_SUB('$maxd', INTERVAL 0 DAY)";
        
        $result = mysqli_query($conn, $sql);
        
        $totalA = 0;
        $totalB = 0;
        $totalC = 0;
        $totalD = 0;
        
        while($row = mysqli_fetch_array($result))  
        {  
            if($row["PRODUCT"] =='A'){
                $totalA = $totalA + $row["COST"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["COST"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["COST"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["COST"];
            }
            
            
        } 
    }
//----------------------------------------------------------------------------
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
        ["Product A", <?php echo $totalA ?>],
        ["Product B", <?php echo $totalB ?>],
        ["Product C", <?php echo $totalC ?>],
        ["Product D", <?php echo $totalD ?>],

        
  
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" }
                       ]);

      var options = {
        title: "Cost of Product (RM)",
        // 'width':'100%',
        // height: 350,
        // bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };

      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
      

  }
  
        
		
  $(window).resize(function(){
            drawChart2();
		});
  </script>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CostOfProduct2</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <style type="text/css">

</style>


</head>
<link rel="stylesheet" type="text/css" href="tnc.css">
<meta name="viewport" content="width=device-wodth, initial-scale=1">
<body style="overflow: hidden;">

 

       <div id="columnchart_values" style="width: 100%; height: 100%;">
   
      
				    
			
  

    
</body>
</html>