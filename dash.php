<?php
// Include config file
require_once "config.php";
session_start();

// Check if the user is already logged in, if no then redirect him to login page
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
  header("location: login.php");
  exit;
}

$conn = new mysqli('localhost', 'justforl_projectadmin', 'JxNB&sx$SP*x', 'justforl_project');
$id = $_SESSION["id"];
$revenue = $_SESSION["revenue"];
$sql = "SELECT * FROM USERS";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
      if($_SESSION["id"] == $row["ID"]){
        $name = $row["NAME"];
      }
  }
} else {
  echo "Error";
}

//Data for Asset, Liability, Equity
$sql2 = "SELECT * FROM OTHERS"; 
$result2 = mysqli_query($conn, $sql2); 
            
if ($result2->num_rows > 0) {
  // output data of each row
  while($row = $result2->fetch_assoc()) {
      
        $rev = $row["REV"];
        $asset = $row["ASSET"];
        $liability = $row["LIABILITY"];
        $equity = $row["EQUITY"];
      
  }
} else {
  echo "Error";
}  


 

?>



<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: #241E1E;
}

.navbar {
  overflow: hidden;
  background-color: #333;
  margin:0px;
}

.navbar a {
  float: right;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: right;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 16px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: red;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}

/*---------------------------------------------------------------------*/

*{
	box-sizing: border-box;
}

.container{
	max-width: 1500px;
	background-color: #241E1E;
	height:auto;
	margin:5px 5px;
	padding:10px;
	
}
h1{
	font-size:30px;
	margin:0;
}
.clear{
	clear: both;
}
nav{
 float:left;
 width: 100%;
 background-color:#dddddd; 
 text-align: center;
 padding:30px 15px;
 margin-bottom:20px;
}

header{
 float:left;
 width: 100%;
 background-color:#dddddd; 
 text-align: center;
 padding:130px 15px;
 margin-bottom:20px;
}

.sectiontop{
 float:left;
 width: 100%;
 background-color:#dddddd; 
 text-align: center;
 padding:10px 5px;
 margin-bottom:10px;
}

.sectiontop .content{
	float:left;
	width: 100%;
	background-color:white;
}

.sectiontop .content .card{
width:25%;
height: 100px;
float: left;
padding:0px 10px;
border: solid 3px;
border-color: grey;
}

.sectiontop .content .card .box{
	background-color:gray;
	font-size:30px;
	color:#fff; 
	height: 300px;
	padding:60px 15px;
}
.topup{
    color:darkblue;
    font-weight:bold;
    font-size:30px
}

.topdown{
    color:black;
    font-weight:bold;
    font-size:25px
}

.section1{
 float:left;
 width: 100%;
 background-color:darkgrey; 
 text-align: center;
 padding: 10px 5px;
 margin-bottom:20px;
}

.section1 .content{
	float:left;
	width: 100%;
	/*background-color:white;*/
	padding:2px 10px;
}

.section1 .content .card{
width:33.3%;
height: 300px;
float: left;
padding:2px 10px;
}

.section1 .content .card .box{
	background-color:gray;
	font-size:30px;
	color:#fff; 
	height: 300px;
	padding:60px 15px;
}

.section2{
 float:left;
 width: 100%;
 background-color:darkgrey; 
 text-align: center;
 padding: 10px 5px;
 margin-bottom:10px;
 margin:0 !important;
 
}
.section2 .content .left .card::after {
  content: "";
  clear: both;
  display: block;
}
.section2 .content .right .card::after {
  content: "";
  clear: both;
  display: block;
}
isplay: block;
}

.section2 .content{
float: left;
width: 100%;
margin-top:0px;
background-color:lightblue;
}

.section2 .content .left{

	float: left;
	padding:2px 10px;
	/*max-width: 830px;*/
    width: 55%;
}
.section2 .content .left .card{
    height: 350px;
    width: 100%;
	/*padding:0px 10px;*/
	font-size:30px;
	color:#fff;
	background-color: gray;
}
.section2 .content .right{
	
	float: left;
	padding: 2px 10px;
	/*max-width: 630px;*/
	width: 44%;
}
.section2 .content .right .card{
    height: 350px;
    width: 100%;
	/*font-size:30px;*/
	color:#fff;
	background-color: gray;

}

h1{
    margin-left: 1%;
}
footer{
 float:left;
 width: 100%;
 background-color:#dddddd; 
 text-align: center;
 padding:50px 10px;
 
}

/*---------------------------------------------------------------------*/

@viewport{
    zoom:1.0;
    width: extend-to-zoom;
}
@-ms-viewport{
    width: extend-to-zoom;
    zoom: 1.0;
} 
@media screen and (max-width: 900px){
    .sectiontop{
    display: flex;
    flex-direction: column;
    margin: 0px;
    
    }
    .section1{
    display: flex;
    flex-direction: column;
    margin: 0px;
    }
    .section2{
    display: flex;
    flex-direction: column;
    margin: 0px;
    }
    
    .sectiontop .content .card .box{
       height: 100px; 
    }
    .topup{
        font-size:25px
       
    }

    .topdown{
        font-size:20px
        
    }
    .sectiontop .content .card  {
    width:100%; /* The width is 100%, when the viewport is 1024px or smaller */
    margin-bottom: 1%;
    height: 100px;
  }
    .section1 .content .card  {
    width:100%; /* The width is 100%, when the viewport is 1024px or smaller */
    margin-bottom: 1%;
  }
  
  
  .section2 .content{
float: none;
width: 100%;
margin-top:0px;
}

.section2 .content .left{
    float: none;
    width:100%;
}
.section2 .content .right{
    float: none;
    width:100%;
}
  
  .section2 .content .left .card{
      float: none;
    width:100%; /* The width is 100%, when the viewport is 1024px or smaller */
  }
  .section2 .content .right .card{
      float: none;
    width:100%; /* The width is 100%, when the viewport is 1024px or smaller */
  }
  
    
}

/*#div_refresh{*/
/*    window.location.href='dash.php';*/
/*}*/

</style>



  </script>

<script src="http://code.jquery.com/jquery-latest.js"></script>



    
</head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" type="text/css" href="dropdown.css">-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
<link rel="stylesheet" type="text/css" href="style2.css">
<!--  <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>-->
<!--<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!--<script src="js/debounce.js"></script>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<body>


<div class="navbar">
  <h1 style="float: left; text-align: center; color:white;">Dashboard</h1>    
  <div class="dropdown">
  <button class="dropbtn" onclick="myFunction()"><?php echo $name; ?><i class="fa fa-caret-down"></i>
  </button>
  <div class="dropdown-content" id="myDropdown" style="right:0">
    <a href="feedback.php"><i class="fas fa-edit"></i> Note</a>
    <a href="manageprofile.php"><i class="fa fa-cog"></i> Manage Profile</a>
    <a href="managepassword.php"><i class="fa fa-lock"></i> Manage Password</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span> Log Out</span></a>

  </div>
  </div>   
  <a href="dash.php">Home</a>

  
</div>

<form method="post">
    <a style="float: right"></a>
    <select name="dateOption" onchange="this.form.submit();" style="float: right" action="dash.php" method="GET" id="the_select">
      <option value=""disabled selected>Date Option</option>
      <option value="today">Today</option>
      <option value="last7day">Last 7 days</option>
      <option value="last30day">Last 30 days</option>
      <option value="last12month">Last 12 months</option>
      <!--<option value="yearly">Yearly</option>-->
      
    </select>
</form>
<?php 
    
    $dateOption = $_POST['dateOption'];
    $_SESSION["dateOption"] = $dateOption;
    
    //Show Option Day
    if($dateOption=="today"){
        $optionDate = "Today";
    }else if($dateOption=="last7day"){
        $optionDate = "Last 7 Days";
    }else if($dateOption=="last30day"){
        $optionDate = "Last 30 Days";
    }else if($dateOption=="last12month"){
        $optionDate = "Last 12 Months";
    }else {
        $optionDate = "Today";
    }
    ?><a style="float: right; color: white;"><?php echo $optionDate."&nbsp";?></a><?php
    
?>




<br>

       <div class="container">
  	  <section class="sectiontop">
  	   	     
  	   	     
  	   	     <div class="content">
  	   	     	 <div class="card" >
  	   	     	 	  <div class="align-self-center " id="div_refresh" font-size:"20px solid">
  	   	     	 	        <?php 
  	   	     	 	        if($dateOption=="today"){
                                $rev = "+5.88 %";
                            }else if($dateOption=="last7day"){
                                $rev = "+16.67 %";
                            }else if($dateOption=="last30day"){
                                $rev = "+16.77 %";
                            }else if($dateOption=="last12month"){
                                $rev = "-49.88 %";
                            }else {
                                $rev = "+5.88 %";
                            }
  	   	     	 	        ?>
  	   	     	 	  	    <span class="topup">Rev Growth</span><br><br>
  	   	     	 	  	    <span class="topdown" ><?php echo $rev?></span>
  	   	     	 	  	
  	   	     	 	  	    
  	   	     	 	  </div>
  	   	     	 </div>
  	   	     	 <div class="card">
  	   	     	 	  <div class="align-self-center " font-size:"20px solid">
  	   	     	 	  	    <span class="topup">Total Asset</span><br><br>
  	   	     	 	  	    <span class="topdown">RM <?php echo number_format("$asset")?></span>
  	   	     	 	  </div>
  	   	     	 </div>
  	   	     	 <div class="card">
  	   	     	 	  <div class="align-self-center " font-size:"20px solid">
  	   	     	 	  	    <span class="topup">Total Liability</span><br><br>
  	   	     	 	  	    <span class="topdown">RM <?php echo number_format("$liability")?></span>
  	   	     	 	  </div>
  	   	     	 </div>
  	   	     	 <div class="card">
  	   	     	 	  <div class="align-self-center " font-size:"20px solid">
  	   	     	 	  	    <span class="topup">Total Equity</span><br><br>
  	   	     	 	  	    <span class="topdown">RM <?php echo number_format("$equity")?></span>
  	   	     	 	  </div>
  	   	     	 </div>
  	   	     	
  	   	     </div>
  	   </section>
      
      <?php
        if($dateOption=="last7day" || $dateOption=="last30day" ||$dateOption=="last12month"){
            ?>
            <div style="color:#C6C6C6;">
                Press the bar for more information. (Please refresh the page of error occur)
                </div>
            <?php
        }?>
        
  	   <section class="section2">
  	   	   <div class="content">
  	   	   	   <div class="left">
  	   	   	   	  <div class="card ">
  	   	   	   	  	<!--Total Sales Profit-->
  	   	   	   	  	 <!--<div id="chart_div" style="width: 100%; height: 100%;"></div>-->
  	   	   	   	  	  <iframe src="graph_totalSales.php" style="width: 100%; height: 100%;"></iframe>
  	   	   	   	  	 <!--<div id="chartContainer" style="width: 100%; height: 100%;"></div>-->
                        
  	   	   	   	  </div>
  	   	   	   </div>
  	   	   	   <div class="right">
  	   	   	   	  <div class="card">
  	   	   	   	      <!--Top 5 Product-->
  	   	   	   	  	  <!--<div id="barchart_material" style="width: 100%; height: 100%;"></div>-->
  	   	   	   	  	  <iframe src="graph_profitProduct.php" style="width: 100%; height: 100%;"></iframe>

  	   	   	   	  </div>
  	   	   	   	  
  	   	   	   </div>
  	   	   </div>
  	   </section>
  	   
  	   <section class="section1">
  	   	     
  	   	     <div class="content">
  	   	     	 <div class="card">
  	   	     	 	  <!--<div class="box">-->
  	   	     	 	  	  <!--Num of product sales-->
  	   	     	 	  	  <!--<div id="columnchart_values" style="width: 100%; height: 100%;"></div>-->
  	   	     	 	  	  <iframe src="graph_noOfProductSales.php" style="width: 100%; height: 100%;"></iframe>
                            
  	   	     	 	  <!--</div>-->
  	   	     	 </div>
  	   	     	 <div class="card">
  	   	     	 	  <!--<div class="box">-->
  	   	     	 	  	  <!--Num Productivity Product-->
  	   	     	 	  	  <!--<div id="columnchart_values2" style="width: 100%; height: 100%;"></div>-->
  	   	     	 	  	  <iframe src="graph_noOfProductivityProduct.php" style="width: 100%; height: 100%;"></iframe>
    
  	   	     	 	  <!--</div>-->
  	   	     	 </div>
  	   	     	 <div class="card">
  	   	     	 	  <!--<div class="box">-->
  	   	     	 	  	  <!--Cost Productivity Product-->
  	   	     	 	  	  <!--<div id="columnchart_values3" style="width: 100%; height: 100%;"></div>-->
  	   	     	 	  	  <iframe src="graph_costOfProduct.php" style="width: 100%; height: 100%;"></iframe>

  	   	     	 	  <!--</div>-->
  	   	     	 </div>
  	   	     	
  	   	     </div>
  	   </section>
  	   
  	   <section class="footer" style="text-align: right;">
  	       <a style="color: white;">Wong</a><br>
  	       <a style="color: white;">&copy Copyright 2021 All Right Reserved<a>
  	   </section>
       
  </div>

</body>
</html>
