<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>

<style>
.chart {
  width: 100%; 
  min-height: 450px;
}
.row {
  margin:0 !important;
}
.section {
    height: 300px;
    width: 50%;
}
</style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
       <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart1);
function drawChart1() {
  var data = google.visualization.arrayToDataTable([
    ['Year', 'Sales', 'Expenses'],
    ['2004',  1000,      400],
    ['2005',  1170,      460],
    ['2006',  660,       1120],
    ['2007',  1030,      540]
  ]);

  var options = {
    title: 'Company Performance',
    hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
 };

var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
  chart.draw(data, options);
}

google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart2);
function drawChart2() {
  var data = google.visualization.arrayToDataTable([
    ['Year', 'Sales', 'Expenses'],
    ['2013',  1000,      400],
    ['2014',  1170,      460],
    ['2015',  660,       1120],
    ['2016',  1030,      540]
  ]);

  var options = {
    title: 'Company Performance',
    hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
    vAxis: {minValue: 0}
  };

  var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
  chart.draw(data, options);
}
$(window).resize(function(){
            drawChart1();
			drawChart2();
		});

// Reminder: you need to put https://www.google.com/jsapi in the head of your document or as an external resource on codepen //
</script>

</head>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<div class="row">
  <div class="col-md-12 text-center">
    <h1>Make Google charts responsive</h1>
    <p>Full blog post details <a href="http://flopreynat.com/blog/make-google-charts-responsive.html">on my blog</a></p>
  </div>
  <div class="col-md-4 col-md-offset-4">
    <hr />
  </div>
  <div class="clearfix"></div>
  <div class="section">
    <div id="chart_div1" </div>
  </div>
  </div>
  <div class="col-md-6">
    <div id="chart_div2" class="chart"></div>
  </div>
</div>

</body>
</html>
