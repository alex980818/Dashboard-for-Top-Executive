<?php
// Include config file
require_once "config.php";
session_start();
$id = $_SESSION['id'];
$dateOption = $_SESSION["dateOption"];
$valid = 0;
// $productType = "All Product";
$productOption ="productAll";
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
        $totalProduct = 0;
        
        while($row = mysqli_fetch_array($result))  
        {  
            if($row["PRODUCT"] =='A'){
                $totalA = $totalA + $row["TOTALSALES"];
                // $totalProduct = $totalProduct + $row["TOTALSALES"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["TOTALSALES"];
                // $totalProduct = $totalProduct + $row["TOTALSALES"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["TOTALSALES"];
                // $totalProduct = $totalProduct + $row["TOTALSALES"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["TOTALSALES"];
                // $totalProduct = $totalProduct + $row["TOTALSALES"];
            }
        } 
        
        $nowDay = $maxd;
        for($i=0;$i<2;$i++){
            
                  $sql2 = "SELECT SUM(TOTALSALES) AS TOTALS FROM PRODUCTS WHERE DATE ='$nowDay'";
                  $result2 = mysqli_query($conn, $sql2);
                  
                  while($row = mysqli_fetch_array($result2)){
                    $maxNowDay[$i] = $nowDay;
                    $totalSales[$i] = $row["TOTALS"];
                    $nowDay = date('Y/m/d', strtotime('-1 day', strtotime($nowDay)));
                    
                    
                 }  
        } 
        
        
        //Get and send revenue
        $rev = ($totalSales[0]-$totalSales[(1)])/$totalSales[(1)]*100;
        $rev = number_format($rev, 2, '.', '');
        // echo "rev: ".$rev;
        
        if($rev>0){
            $revenue = "+ $rev %";
        }else {
            $revenue = "$rev %";
        }
        // echo " | revenue: ".$revenue;
        $_SESSION["revenue"] = $revenue;
        
        //Update Rev database
        $sqlRev = "UPDATE OTHERS SET REV ='$revenue' WHERE OTID = 1";
            
            if($stmt = mysqli_prepare($link, $sqlRev)){
                mysqli_stmt_bind_param($stmt, "s", $param_rev);
                $param_rev = $revenue;
        }
        if ($conn->query($sqlRev) === TRUE) {
        //   echo "Record updated successfully";
        } else {
        //   echo "Error updating record: " . $conn->error;
        }
    }else if($dateOption=="last7day"){

        $nowDay = $maxd;
        $lastday = date('Y-m-d', strtotime('-6 day', strtotime($nowDay)));
        $i=0;

            
                  
                  
                  if($productOption=="productA"){
                      $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay' AND PRODUCT = 'A'";
                      $result2 = mysqli_query($conn, $sql2);
                  }else if($productOption =="productB"){
                      $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay' AND PRODUCT = 'B'";
                      $result2 = mysqli_query($conn, $sql2);
                  }else if($productOption =="productC"){
                      $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay' AND PRODUCT = 'C'";
                      $result2 = mysqli_query($conn, $sql2);
                  }else if($productOption =="productD"){
                      $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay' AND PRODUCT = 'D'";
                      $result2 = mysqli_query($conn, $sql2);
                  }else if($productOption =="productAll") {
                      $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay'";
                      $result2 = mysqli_query($conn, $sql2);
                  }
                  
                 
                  while($row = mysqli_fetch_array($result2)){
                      
                    $maxNowDay[$i] = $nowDay;
                    $product[$i] = $row["PRODUCT"];
                    $totalDate[$i] = $row["DATE"];
                    $totalSales[$i] = $row["TOTALSALES"];

                    
                    // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                    // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                    // echo nl2br($i." totalSales: ".$row["TOTALSALES"]."\n");
                    // echo nl2br("------------------------------------------\n");
                    $i++;
                    
                    
                 }  
        
        
        //Get and send revenue
        $rev = ($totalSales[$i-1]-$totalSales[(0)])/$totalSales[(0)]*100;
        $rev = number_format($rev, 2, '.', '');
        // echo "rev: ".$rev;
        
        if($rev>0){
            $revenue = "+ $rev %";
        }else {
            $revenue = "$rev %";
        }
        // echo " | revenue: ".$revenue;
        $_SESSION["revenue"] = $revenue;
        
        //Update Rev database
        $sqlRev = "UPDATE OTHERS SET REV ='$revenue' WHERE OTID = 1";
            
            if($stmt = mysqli_prepare($link, $sqlRev)){
                mysqli_stmt_bind_param($stmt, "s", $param_rev);
                $param_rev = $revenue;
        }
        if ($conn->query($sqlRev) === TRUE) {
        //   echo "Record updated successfully";
        } else {
        //   echo "Error updating record: " . $conn->error;
        }
        

    }else if($dateOption=="last30day"){ 

        $nowDay = $maxd;
        $lastday = date('Y-m-d', strtotime('-29 day', strtotime($nowDay)));
        $i=0;

            
                  if($productOption=="productA"){
                      $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay' AND PRODUCT = 'A'";
                      $result2 = mysqli_query($conn, $sql2);
                  }else if($productOption =="productB"){
                      $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay' AND PRODUCT = 'B'";
                      $result2 = mysqli_query($conn, $sql2);
                  }else if($productOption =="productC"){
                      $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay' AND PRODUCT = 'C'";
                      $result2 = mysqli_query($conn, $sql2);
                  }else if($productOption =="productD"){
                      $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay' AND PRODUCT = 'D'";
                      $result2 = mysqli_query($conn, $sql2);
                  }else{
                      $sql2 = "SELECT * FROM PRODUCTS WHERE DATE BETWEEN '$lastday' AND '$nowDay'";
                      $result2 = mysqli_query($conn, $sql2);
                  }
                  
                  while($row = mysqli_fetch_array($result2)){
                      
                    $maxNowDay[$i] = $nowDay;
                    $product[$i] = $row["PRODUCT"];
                    $totalDate[$i] = date("m/d", strtotime($row["DATE"]));
                    $totalSales[$i] = $row["TOTALSALES"];

                    
                    // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                    // echo nl2br($i." maxNowDays: ".$row["DATE"]."\n");
                    // echo nl2br($i." totalSales: ".$row["TOTALSALES"]."\n");
                    // echo nl2br("------------------------------------------\n");
                    $i++;
                    
                    
                 }  
        
        //Get and send revenue
        $rev = ($totalSales[$i-1]-$totalSales[(0)])/$totalSales[(0)]*100;
        $rev = number_format($rev, 2, '.', '');
        // echo "rev: ".$rev;
        
        if($rev>0){
            $revenue = "+ $rev %";
        }else {
            $revenue = "$rev %";
        }
        // echo " | revenue: ".$revenue;
        $_SESSION["revenue"] = $revenue;
        
        //Update Rev database
        $sqlRev = "UPDATE OTHERS SET REV ='$revenue' WHERE OTID = 1";
            
            if($stmt = mysqli_prepare($link, $sqlRev)){
                mysqli_stmt_bind_param($stmt, "s", $param_rev);
                $param_rev = $revenue;
        }
        if ($conn->query($sqlRev) === TRUE) {
        //   echo "Record updated successfully";
        } else {
        //   echo "Error updating record: " . $conn->error;
        }
        
    }else if ($dateOption=="last12month"){
        
     

        $nowDay = $maxd;
        $lastmonth = date('m', strtotime('-11 month', strtotime($nowDay)));
        $lastyear = date('Y', strtotime('-1 year', strtotime($nowDay)));
        $lastday = "$lastyear-$lastmonth-01";
        $i=0;
        
        // echo nl2br("nowDay : ".$nowDay."\n");
        // echo nl2br("lastmonth : ".$lastmonth."\n");
        // echo nl2br("lastyear : ".$lastyear."\n");
        // echo nl2br("lastday : ".$lastday."\n");
            
                //   For Product A last 12month
                  $sql2 = "SELECT PRODUCT, DATE, SUM(TOTALSALES) AS TOTALS FROM PRODUCTS WHERE PRODUCT = 'A' AND DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                  $result2 = mysqli_query($conn, $sql2);
                  
                  while($row = mysqli_fetch_array($result2)){
                    
                    $nowMonth = date("Y/m", strtotime($row["DATE"]));
                    // echo nl2br("nowMonth : ".$nowMonth."\n");
                    
                  
                  
                    
                    $product[$i] = $row["PRODUCT"];
                    $totalDate[$i] = $nowMonth;
                    $totalSales[$i] = $row["TOTALS"];

                    
                    // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                    // echo nl2br($i." nowMonth: ". $nowMonth."\n");
                    // echo nl2br($i." totalSales: ".$row["TOTALS"]."\n");
                    // echo nl2br("------------------------------------------\n");
                    $i++;
                    
                    
                 }  
                 //   For Product B last 12month
                  $sql2 = "SELECT PRODUCT, DATE, SUM(TOTALSALES) AS TOTALS FROM PRODUCTS WHERE PRODUCT = 'B' AND DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                  $result2 = mysqli_query($conn, $sql2);
                  
                  while($row = mysqli_fetch_array($result2)){
                    
                    $nowMonth = date("Y/m", strtotime($row["DATE"]));
                    // echo nl2br("nowMonth : ".$nowMonth."\n");
                    
                    
                    $product[$i] = $row["PRODUCT"];
                    $totalDate[$i] = $nowMonth;
                    $totalSales[$i] = $row["TOTALS"];

                    
                    // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                    // echo nl2br($i." nowMonth: ". $nowMonth."\n");
                    // echo nl2br($i." totalSales: ".$row["TOTALS"]."\n");
                    // echo nl2br("------------------------------------------\n");
                    $i++;
                    
                    
                 }  
                 //   For Product C last 12month
                  $sql2 = "SELECT PRODUCT, DATE, SUM(TOTALSALES) AS TOTALS FROM PRODUCTS WHERE PRODUCT = 'C' AND DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                  $result2 = mysqli_query($conn, $sql2);
                  
                  while($row = mysqli_fetch_array($result2)){
                    
                    $nowMonth = date("Y/m", strtotime($row["DATE"]));
                    // echo nl2br("nowMonth : ".$nowMonth."\n");
                    
                    
                    $product[$i] = $row["PRODUCT"];
                    $totalDate[$i] = $nowMonth;
                    $totalSales[$i] = $row["TOTALS"];

                    
                    // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                    // echo nl2br($i." nowMonth: ". $nowMonth."\n");
                    // echo nl2br($i." totalSales: ".$row["TOTALS"]."\n");
                    // echo nl2br("------------------------------------------\n");
                    $i++;
                    
                    
                 } 
                 //   For Product D last 12month
                  $sql2 = "SELECT PRODUCT, DATE, SUM(TOTALSALES) AS TOTALS FROM PRODUCTS WHERE PRODUCT = 'D' AND DATE BETWEEN '$lastday' AND '$nowDay' GROUP BY MONTH(DATE) ORDER BY DATE";
                  $result2 = mysqli_query($conn, $sql2);
                  
                  while($row = mysqli_fetch_array($result2)){
                    
                    $nowMonth = date("Y/m", strtotime($row["DATE"]));
                    // echo nl2br("nowMonth : ".$nowMonth."\n");
                    
                    
                    $product[$i] = $row["PRODUCT"];
                    $totalDate[$i] = $nowMonth;
                    $totalSales[$i] = $row["TOTALS"];

                    
                    // echo nl2br($i." Product: ".$row["PRODUCT"]."\n");
                    // echo nl2br($i." nowMonth: ". $nowMonth."\n");
                    // echo nl2br($i." totalSales: ".$row["TOTALS"]."\n");
                    // echo nl2br("------------------------------------------\n");
                    $i++;
                    
                    
                 }  
        
        //Get and send revenue
        $rev = ($totalSales[$i-1]-$totalSales[(0)])/$totalSales[(0)]*100;
        $rev = number_format($rev, 2, '.', '');
        // echo "rev: ".$rev;
        
        if($rev>0){
            $revenue = "+ $rev %";
        }else {
            $revenue = "$rev %";
        }
        // echo " | revenue: ".$revenue;
        $_SESSION["revenue"] = $revenue;
        
        //Update Rev database
        $sqlRev = "UPDATE OTHERS SET REV ='$revenue' WHERE OTID = 1";
            
            if($stmt = mysqli_prepare($link, $sqlRev)){
                mysqli_stmt_bind_param($stmt, "s", $param_rev);
                $param_rev = $revenue;
        }
        if ($conn->query($sqlRev) === TRUE) {
        //   echo "Record updated successfully";
        } else {
        //   echo "Error updating record: " . $conn->error;
        }
        
        // for($i=0;$i<12;$i++){
        //     echo "  |    maxNowMonth[$i] = ".$maxNowMonth[$i]; 
        //     echo "  |    totalSales[$i] = ".$totalSales[$i];   
        //     // echo "nowMonth = ".$nowMonth;
        // }
        
    }else{
        $sql = "SELECT * FROM PRODUCTS WHERE DATE >= DATE_SUB('$maxd', INTERVAL 0 DAY)";

        
        $result = mysqli_query($conn, $sql);
        
        $totalA = 0;
        $totalB = 0;
        $totalC = 0;
        $totalD = 0;
        $totalProduct = 0;
        
        while($row = mysqli_fetch_array($result))  
        {  
            if($row["PRODUCT"] =='A'){
                $totalA = $totalA + $row["TOTALSALES"];
                $totalProduct = $totalProduct + $row["TOTALSALES"];
            }else if($row["PRODUCT"] =='B'){
                $totalB = $totalB + $row["TOTALSALES"];
                $totalProduct = $totalProduct + $row["TOTALSALES"];
            }else if($row["PRODUCT"] =='C'){
                $totalC = $totalC + $row["TOTALSALES"];
                $totalProduct = $totalProduct + $row["TOTALSALES"];
            }else if($row["PRODUCT"] =='D'){
                $totalD = $totalD + $row["TOTALSALES"];
                $totalProduct = $totalProduct + $row["TOTALSALES"];
            }
            
            
        }
        
        $nowDay = $maxd;
        for($i=0;$i<2;$i++){
            
                  $sql2 = "SELECT SUM(TOTALSALES) AS TOTALS FROM PRODUCTS WHERE DATE ='$nowDay'";
                  $result2 = mysqli_query($conn, $sql2);
                  
                  while($row = mysqli_fetch_array($result2)){
                    $maxNowDay[$i] = $nowDay;
                    $totalSales[$i] = $row["TOTALS"];
                    $nowDay = date('Y/m/d', strtotime('-1 day', strtotime($nowDay)));
                    
                    
                 }  
        } 
        
        
        //Get and send revenue
        $rev = ($totalSales[0]-$totalSales[(1)])/$totalSales[(1)]*100;
        $rev = number_format($rev, 2, '.', '');
        // echo "rev: ".$rev;
        
        if($rev>0){
            $revenue = "+ $rev %";
        }else {
            $revenue = "$rev %";
        }
        // echo " | revenue: ".$revenue;
        $_SESSION["revenue"] = $revenue;
        
        //Update Rev database
        $sqlRev = "UPDATE OTHERS SET REV ='$revenue' WHERE OTID = 1";
            
            if($stmt = mysqli_prepare($link, $sqlRev)){
                mysqli_stmt_bind_param($stmt, "s", $param_rev);
                $param_rev = $revenue;
        }
        if ($conn->query($sqlRev) === TRUE) {
        //   echo "Record updated successfully";
        } else {
        //   echo "Error updating record: " . $conn->error;
        }
    }
//----------------------------------------------------------------------------
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!--Graph for last7day, last30day, last12month-->
<!------------------Total Sales-------------------------------------------->
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
        
       for($j=0; $j<$i; $j++){ ?>                                          //$thrend[$i]
                ['<?echo $totalDate[$j] ?>',  '<?echo $product[$j] ?>', <?echo $totalSales[$j] ?>],
      <?php }?>
                 
         
    ]);
    
    var aggregateData = google.visualization.data.group(data, [0], [{
        type: 'number',
        label: 'All Product',
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
            options.title = 'Total Sales(RM)';
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
    
<!--Graph for today OR Product A, B, C, D -->
<!------------------Total Sales-------------------------------------------->

    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);
      
   
      
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

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          
        //   ['2020/05',  614.6, 614.6],
        //   ['2020/06',  682, 682],
        //   ['2020/07',  623, 623],
        //   ['2020/08',  609.4, 609.4],
        //   ['2020/09',  569.6, 569.6]
        
    <?php if($dateOption=="today"){ ?>
             ['Month', 'Product '],
             ['Product A',  <?echo $totalA ?>],
             ['Product B',  <?echo $totalB ?>],
             ['Product C',  <?echo $totalC ?>],
             ['Product D',  <?echo $totalD ?>]
    <?php }else if($dateOption=="last7day"){ 
        
      ?>    ['Month', 'Product <?php echo $product[0]?>'], <?php
         
      for($j=0; $j<$i; $j++){ ?>                                          
                ['<?echo $totalDate[$j] ?>', <?echo $totalSales[$j] ?>],
      <?php }?>
        
      <?php }else if($dateOption=="last30day"){ 
          
      ?>    ['Month', 'Product <?php echo $product[0]?>'], <?php
         
      for($j=0; $j<$i; $j++){ ?>                                          
                ['<?echo $totalDate[$j] ?>', <?echo $totalSales[$j] ?>],
      <?php }?>
        
      <?php }else if($dateOption=="last12month"){ 
          
      ?>    ['Month', 'Product <?php echo $product[0]?>'], <?php
         
      for($j=0; $j<$i; $j++){ ?>                                          
                ['<?echo $totalDate[$j] ?>', <?echo $totalSales[$j] ?>],
      <?php }?>
        
      <?php }else{ ?>
             ['Month', 'Product '],
             ['Product A',  <?echo $totalA ?>],
             ['Product B',  <?echo $totalB ?>],
             ['Product C',  <?echo $totalC ?>],
             ['Product D',  <?echo $totalD ?>]
    <?php }?>
    
        ]);

        var options = {
          title : 'Total Sales (RM)',
          vAxis: {title: 'RM'},
        //   hAxis: {title: 'Product'},
        //  curveType: 'function',
          seriesType: 'bars',
          series: {1: {type: 'line'}}
        };




        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));

        chart.draw(data, options);
        
		
      }
      
      
       $(window).resize(function(){
        drawChart();
        drawVisualization();
    });
    </script>
    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>totalSales2</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <style type="text/css">

</style>


</head>
<link rel="stylesheet" type="text/css" href="tnc.css">
<meta name="viewport" content="width=device-wodth, initial-scale=1">
<body style="overflow: hidden; ">

    <?php if ($dateOption=="last7day" || $dateOption=="last30day" ||$dateOption=="last12month"){ ?>
        <div >
            <form method="post">

              <select name="productOption" onchange="this.form.submit();" style="float: right" action="graph_totalSales2.php" method="GET">
                <option value=""disabled selected>Select Product</option>
                <option value="productAll">All Product</option>
                <option value="productA">Product A</option>
                <option value="productB">Product B</option>
                <option value="productC">Product C</option>
                <option value="productD">Product D</option>
              </select>
              
              <!--<input type="submit" value="Submit">-->
            </form>
            
            <?php 
               $productOption = $_POST['productOption'];
               $_SESSION["productOption"] = $productOption;?>
        
        
              <?php 
              if($productOption=='productAll'){ 
                    $productType = "All Product";
              }else if($productOption=="productA"){ 
                    $productType = "Product A";
              }else if($productOption=="productB"){ 
                    $productType = "Product B";
              }else if($productOption=="productC"){ 
                    $productType = "Product C";
              }else if($productOption=="productD"){ 
                    $productType = "Product D";
              }else{
                  $productType = "All Product";
              }
              
              ?>
              <a style="float: right; color: black;"><?php echo $productType."&nbsp";?></a>
              <br>
        </div>
        <?php } ?>

        
        <?php if($dateOption=="today"){?>
            <div id="chart_div" style="width: 100%; height: 100%;"></div>
        <?php } else if ($dateOption=="last7day" || $dateOption=="last30day" ||$dateOption=="last12month"){?>
        
       <!--<div id="chart" style="width: 100%; height: 100%;"></div>-->
       <?php 
       if($productOption=="productA"||$productOption=="productB"||$productOption=="productC"||$productOption=="productD"){?>
            <!--<div id="chart_div" style="width: 100%; height: 100%;"></div>-->
            <iframe src="graph_totalSales3.php" style="width: 100%; height: 100%;"></iframe>
        <?php }else{?>
            <div id="chart" style="width: 100%; height: 100%;"></div>
        <?php }?>
       
        <?php } else{ ?>
            <div id="chart_div" style="width: 100%; height: 100%;"></div>
		<?php } ?>		
        
        
       

       
 

    
</body>
</html>