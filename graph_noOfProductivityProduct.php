<?php
// Include config file
require_once "config.php";
session_start();
$id = $_SESSION['id'];
$dateOption = $_SESSION["dateOption"];
$valid = 0;
// $dateOption = 'today';
// $dateOption = 'last7day';
// $dateOption = 'last30day';
// $dateOption = 'last12month';

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
                $totalA = $totalA + $row["PRODUCTIVITY"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["PRODUCTIVITY"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["PRODUCTIVITY"];
            }
            else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["PRODUCTIVITY"];
            }
            
            
        } 
    }else if($dateOption=="last7day"){
        $nowDay = $maxd;
        $lastday = date('Y-m-d', strtotime('-6 day', strtotime($nowDay)));
        $i=0;
        
        $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay'";
        $result2 = mysqli_query($conn, $sql2);
        
        while($row = mysqli_fetch_array($result2)){
                      
                    $maxNowDay[$i] = $nowDay;
                    $product[$i] = $row["PRODUCT"];
                    $totalDate[$i] = $row["DATE"];
                    $productivity[$i] = $row["PRODUCTIVITY"];

                    
                    // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                    // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                    // echo nl2br($i." totalSales: ".$row["TOTALSALES"]."\n");
                    // echo nl2br("------------------------------------------\n");
                    $i++;
                    
                    
                 } 
    }else if($dateOption=="last30day"){ 
        $nowDay = $maxd;
        $lastday = date('Y-m-d', strtotime('-29 day', strtotime($nowDay)));
        $i=0;

            $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay'";
        $result2 = mysqli_query($conn, $sql2);
        
        while($row = mysqli_fetch_array($result2)){
                      
                    $maxNowDay[$i] = $nowDay;
                    $product[$i] = $row["PRODUCT"];
                    $totalDate[$i] = $row["DATE"];
                    $productivity[$i] = $row["PRODUCTIVITY"];

                    
                    // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                    // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                    // echo nl2br($i." totalSales: ".$row["TOTALSALES"]."\n");
                    // echo nl2br("------------------------------------------\n");
                    $i++;
                    
                    
                 } 
    }else if ($dateOption=="last12month"){
        $nowDay = $maxd;
        $lastmonth = date('m', strtotime('-11 month', strtotime($nowDay)));
        $lastyear = date('Y', strtotime('-1 year', strtotime($nowDay)));
        $lastday = "$lastyear-$lastmonth-01";
        $i=0;
        
                //   For Product A last 12month
                $sql2 = "SELECT PRODUCT, DATE, SUM(PRODUCTIVITY) AS TOTALPRODUCTIVITY FROM PRODUCTS WHERE PRODUCT = 'A' AND 
                DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                $result2 = mysqli_query($conn, $sql2);
                      while($row = mysqli_fetch_array($result2)){
                            $nowMonth = date("Y/m", strtotime($row["DATE"]));
                            $maxNowDay[$i] = $nowDay;
                            $product[$i] = $row["PRODUCT"];
                            $totalDate[$i] = $nowMonth;
                            $productivity[$i] = $row["TOTALPRODUCTIVITY"];
                        
                            
                            // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                            // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                            // echo nl2br($i." totalProfit: ".$row["TOTALPROFIT"]."\n");
                            // echo nl2br("------------------------------------------\n");
                            $i++;
                            
                            
                         } 

                //   For Product B last 12month
                $sql2 = "SELECT PRODUCT, DATE, SUM(PRODUCTIVITY) AS TOTALPRODUCTIVITY FROM PRODUCTS WHERE PRODUCT = 'B' AND 
                DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                $result2 = mysqli_query($conn, $sql2);
                      while($row = mysqli_fetch_array($result2)){
                            $nowMonth = date("Y/m", strtotime($row["DATE"]));
                            $maxNowDay[$i] = $nowDay;
                            $product[$i] = $row["PRODUCT"];
                            $totalDate[$i] = $nowMonth;
                            $productivity[$i] = $row["TOTALPRODUCTIVITY"];
        
                            
                            // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                            // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                            // echo nl2br($i." totalProfit: ".$row["TOTALPROFIT"]."\n");
                            // echo nl2br("------------------------------------------\n");
                            $i++;
                            
                            
                         } 
                         
                //   For Product C last 12month
                $sql2 = "SELECT PRODUCT, DATE, SUM(PRODUCTIVITY) AS TOTALPRODUCTIVITY FROM PRODUCTS WHERE PRODUCT = 'C' AND 
                DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                $result2 = mysqli_query($conn, $sql2);
                      while($row = mysqli_fetch_array($result2)){
                            $nowMonth = date("Y/m", strtotime($row["DATE"]));
                            $maxNowDay[$i] = $nowDay;
                            $product[$i] = $row["PRODUCT"];
                            $totalDate[$i] = $nowMonth;
                            $productivity[$i] = $row["TOTALPRODUCTIVITY"];
        
                            
                            // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                            // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                            // echo nl2br($i." totalProfit: ".$row["TOTALPROFIT"]."\n");
                            // echo nl2br("------------------------------------------\n");
                            $i++;
                            
                            
                         } 
                //   For Product D last 12month
                $sql2 = "SELECT PRODUCT, DATE, SUM(PRODUCTIVITY) AS TOTALPRODUCTIVITY FROM PRODUCTS WHERE PRODUCT = 'D' AND 
                DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                $result2 = mysqli_query($conn, $sql2);
                      while($row = mysqli_fetch_array($result2)){
                            $nowMonth = date("Y/m", strtotime($row["DATE"]));
                            $maxNowDay[$i] = $nowDay;
                            $product[$i] = $row["PRODUCT"];
                            $totalDate[$i] = $nowMonth;
                            $productivity[$i] = $row["TOTALPRODUCTIVITY"];
        
                            
                            // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                            // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                            // echo nl2br($i." totalProfit: ".$row["TOTALPROFIT"]."\n");
                            // echo nl2br("------------------------------------------\n");
                            $i++;
                            
                            
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
                $totalA = $totalA + $row["PRODSALES"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["PRODSALES"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["PRODSALES"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["PRODSALES"];
            }
            
            
        }
    }
//----------------------------------------------------------------------------
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="~/Content/js/google-chart-loader.js"></script>

<!-------------noOfProductivity for last7day, last30day, last12month------------------->

<script type="text/javascript">
    //   google.charts.load('current', {'packages':['corechart']});
    //   google.charts.setOnLoadCallback(drawVisualization);
          //Responsive  
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
   
      
function drawChart () {
    var data = google.visualization.arrayToDataTable([
        ['Month', 'Total Sales ','Unit'], <?php
        
       for($j=0; $j<$i; $j++){ ?>                                          
                ['<?echo $product[$j] ?>', '<?echo $totalDate[$j] ?>', <?echo $productivity[$j] ?>],
      <?php }?>
                 
         
    ]);
    
    var aggregateData = google.visualization.data.group(data, [0], [{
        type: 'number',
        label: 'Unit',
        column: 2,
        aggregation: google.visualization.data.sum
    }]);
    
    var topLevel = true;
    
    var chart = new google.visualization.ColumnChart(document.querySelector('#chart'));
    var options = {
        // height: 400,
        // width: 600
        'chartArea': {
            'backgroundColor': {
                'fill': '#F4F4F4',
                'opacity': 100
             },
         }
    };
    
    function draw (category) {
        if (topLevel) {
            // rename the title
            options.title = 'Number of Productivity Product (Unit)';
            // draw the chart using the aggregate data
            chart.draw(aggregateData, options);
        }
        else {
            var view = new google.visualization.DataView(data);
            // use columns "Name" and "Value"
            view.setColumns([1, 2]);
            // filter the data based on the category
            view.setRows(data.getFilteredRows([{column: 0, value: category}]));
            // rename the title
            options.title = 'Product: ' + category;
            // draw the chart using the view
            chart.draw(view, options);
        }
    }
    
    google.visualization.events.addListener(chart, 'select', function () {
        if (topLevel) {
            var selection = chart.getSelection();
            // drill down if the selection isn't empty
            if (selection.length) {
                var category = aggregateData.getValue(selection[0].row, 0);
                topLevel = false;
                draw(category);
            }
        }
        else {
            // go back to the top
            topLevel = true;
            draw();
        }
    });
    
    draw();
}
google.load('visualization', '1', {packages: ['corechart'], callback: drawChart});

    
      
      $(window).resize(function(){
        drawChart();
        drawVisualization();
    });
    </script>
    
<!------------------------noOfProductSales for today-------------------------->
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
        title: "Number of Productivity Product (Unit)",
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
    <title>Productivity</title>
    <!--<title>PSales2</title>-->
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


   
      <?php
        if($dateOption=="last7day" || $dateOption=="last30day" ||$dateOption=="last12month"){
            ?>
            <div id="chart" style="width: 100%; height: 100%;">
            <?php
        }else{?>
            <div id="columnchart_values" style="width: 100%; height: 100%;">
            <?php
        }?>
				    
			
  

    
</body>
</html>