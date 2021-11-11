<?php
// Include config file
require_once "config.php";
session_start();
$id = $_SESSION['id'];
$dateOption = $_SESSION["dateOption"];
$valid = 0;
// $productType = "All Product";
// $productOption ="productAll";
// $dateOption = 'last7day';

 $conn = new mysqli('localhost', 'justforl_projectadmin', 'JxNB&sx$SP*x', 'justforl_project');
 
 
// Get Latest Date
$sqlDate = "SELECT MAX(DATE) AS MAXDATE, MONTH(MAX(DATE)) AS MAXMONTH, YEAR(MAX(DATE)) AS MAXYEAR FROM PRODUCTS";
$result0 = mysqli_query($conn, $sqlDate);
        
    while($row = mysqli_fetch_array($result0)){  
         $maxd = $row["MAXDATE"];
         $maxm = $row["MAXMONTH"];
         $maxy = $row["MAXYEAR"];
         $lastY = $row["MAXYEAR"]-1;
         $formatM2 = date('Y-M',strtotime($maxd));
    }
   
// echo "  MAxDate= ".$maxd;
// echo "  MAxMonth= ".$maxm;
// echo "  MAxYear= ".$maxy; 
// echo "  LastY= ".$lastY; 
// echo '  LastYear= '.$lastY.'-'.$maxm.'-01';
// echo "  formatM2 = ".$formatM2;


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
                $totalA = $totalA + $row["PROFIT"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["PROFIT"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["PROFIT"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["PROFIT"];
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
                    $profit[$i] = $row["PROFIT"];

                    
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
                    $profit[$i] = $row["PROFIT"];

                    
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
                $sql2 = "SELECT PRODUCT, DATE, SUM(PROFIT) AS TOTALPROFIT FROM PRODUCTS WHERE PRODUCT = 'A' AND 
                DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                $result2 = mysqli_query($conn, $sql2);
                      while($row = mysqli_fetch_array($result2)){
                            $nowMonth = date("Y/m", strtotime($row["DATE"]));
                            $maxNowDay[$i] = $nowDay;
                            $product[$i] = $row["PRODUCT"];
                            $totalDate[$i] = $nowMonth;
                            $profit[$i] = $row["TOTALPROFIT"];
                        
                            
                            // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                            // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                            // echo nl2br($i." totalProfit: ".$row["TOTALPROFIT"]."\n");
                            // echo nl2br("------------------------------------------\n");
                            $i++;
                            
                            
                         } 

                //   For Product B last 12month
                $sql2 = "SELECT PRODUCT, DATE, SUM(PROFIT) AS TOTALPROFIT FROM PRODUCTS WHERE PRODUCT = 'B' AND 
                DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                $result2 = mysqli_query($conn, $sql2);
                      while($row = mysqli_fetch_array($result2)){
                            $nowMonth = date("Y/m", strtotime($row["DATE"]));
                            $maxNowDay[$i] = $nowDay;
                            $product[$i] = $row["PRODUCT"];
                            $totalDate[$i] = $nowMonth;
                            $profit[$i] = $row["TOTALPROFIT"];
        
                            
                            // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                            // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                            // echo nl2br($i." totalProfit: ".$row["TOTALPROFIT"]."\n");
                            // echo nl2br("------------------------------------------\n");
                            $i++;
                            
                            
                         } 
                         
                //   For Product C last 12month
                $sql2 = "SELECT PRODUCT, DATE, SUM(PROFIT) AS TOTALPROFIT FROM PRODUCTS WHERE PRODUCT = 'C' AND 
                DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                $result2 = mysqli_query($conn, $sql2);
                      while($row = mysqli_fetch_array($result2)){
                            $nowMonth = date("Y/m", strtotime($row["DATE"]));
                            $maxNowDay[$i] = $nowDay;
                            $product[$i] = $row["PRODUCT"];
                            $totalDate[$i] = $nowMonth;
                            $profit[$i] = $row["TOTALPROFIT"];
        
                            
                            // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                            // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                            // echo nl2br($i." totalProfit: ".$row["TOTALPROFIT"]."\n");
                            // echo nl2br("------------------------------------------\n");
                            $i++;
                            
                            
                         } 
                //   For Product D last 12month
                $sql2 = "SELECT PRODUCT, DATE, SUM(PROFIT) AS TOTALPROFIT FROM PRODUCTS WHERE PRODUCT = 'D' AND 
                DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                $result2 = mysqli_query($conn, $sql2);
                      while($row = mysqli_fetch_array($result2)){
                            $nowMonth = date("Y/m", strtotime($row["DATE"]));
                            $maxNowDay[$i] = $nowDay;
                            $product[$i] = $row["PRODUCT"];
                            $totalDate[$i] = $nowMonth;
                            $profit[$i] = $row["TOTALPROFIT"];
        
                            
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
                $totalA = $totalA + $row["PROFIT"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["PROFIT"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["PROFIT"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["PROFIT"];
            }
            
            
        }
    }
//----------------------------------------------------------------------------
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!------------------Profit Product for last7day, last30day, last12month----------------------------------->
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
        ['Month', 'Total Sales ','RM'], <?php
        
       for($j=0; $j<$i; $j++){ ?>                                          
                ['<?echo $product[$j] ?>', '<?echo $totalDate[$j] ?>', <?echo $profit[$j] ?>],
      <?php }?>
                 
         
    ]);
    
    var aggregateData = google.visualization.data.group(data, [0], [{
        type: 'number',
        label: 'RM',
        column: 2,
        aggregation: google.visualization.data.sum
    }]);
    
    var topLevel = true;
    
    var chart = new google.visualization.BarChart(document.querySelector('#chart'));
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
            options.title = 'Profit Product (RM)';
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
            options.title = 'Category: ' + category;
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
    
<!---------------------------Profit Product for today-------------------------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<?php
$sql = "SELECT * FROM PRODUCTS WHERE DATE >= DATE_SUB('$maxd', INTERVAL 0 DAY)";
        
        $result = mysqli_query($conn, $sql);
        
        $totalA = 0;
        $totalB = 0;
        $totalC = 0;
        $totalD = 0;
        
        while($row = mysqli_fetch_array($result))  
        {  
            if($row["PRODUCT"] =='A'){
                $totalA = $totalA + $row["PROFIT"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["PROFIT"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["PROFIT"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["PROFIT"];
            }
            
          
        } 
?>

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
        ['Product A', '<?php echo number_format("$totalA") ?>'],
        ['Product B', '<?php echo number_format("$totalB") ?>'],
        ['Product C', '<?php echo number_format("$totalC") ?>'],
        ['Product D', '<?php echo number_format("$totalD") ?>'],
        

         ]);

        var options = {
            
          chart: {
            title: 'Profit of Products',
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
    <title>profitProduct</title>
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

    
<div style="width: 100%; height: 100%;">
        
       
            <div id="chart" style="width: 100%; height: 100%;">
      	
        
</div>        
       

       
 

    
</body>
</html>