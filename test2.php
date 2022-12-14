<html>
<head>
<title>Slot Test</title>
    <link rel="apple-touch-icon" href="https://cdn.pixabay.com/photo/2014/04/02/10/45/parking-304464_960_720.png">
    <link rel="shortcut icon" href="https://cdn.pixabay.com/photo/2014/04/02/10/45/parking-304464_960_720.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
     <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> 
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
<style type="text/css">
{
  box-sizing: border-box;
}

body {
  margin: 0;
}

.bolded { font-weight: bold;
		font-size: 1.5em; }
.header {
  background-color: #f1f1f1;
  padding: 20px;
  text-align: center;
}
h2{
text-align: center;
}
h3{
text-align: center;
}


table {
margin: 8px;
}


th {
font-family: Arial, Helvetica, sans-serif;
font-size: 1em;
background: #666;
color: #FFF;
padding: 2px 6px;
border-collapse: separate;
border: 1px solid #000;
}

td {
font-family: Arial, Helvetica, sans-serif;
text-align: center;
font-size: .9em;
border: 1px solid #DDD;
}
.box{
width: 100px;
height: 70px;
border: 1px solid black;
margin: 8px;
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #111;
}
#weatherWidget .currentDesc {
        color: #ffffff!important;
    }
        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }
</style>
</head>
<body>
<div class="header">
  <h1>IOT BASED SMART PARKING SYSTEM</h1>
</div>
<ul>
  <li><a class="active" href="test2.php">Refresh</a></li><li><a class="active" href="test3.php">Records</a></li><li><a class="active" href="test5.php">Search</a></li><li><a class="active" href="test4.php">Stats</a></li>
</ul>

<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
require 'vendor/autoload.php';
require 'credentials.php';


date_default_timezone_set('UTC');



use Aws\DynamoDb\Marshaler;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;


$dynamodb = DynamoDbClient::factory(array(
    'credentials' => array(
        'key'    => 'AKIAWKLX2HYTBDKOLITP',
        'secret' => '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'
    ),'region' => 'us-east-1',
	'version' => 'latest'
));
//    echo "Getting data from sensor "."<br>";
$result = $dynamodb->describeTable(array(
    'TableName' => 'slots'
));

// The result of an operation can be used like an array
echo "<h2>"."Total slots: ".$result['Table']['ItemCount'] . "</h2>";

function scanAllData($table,$limit,$db1){

  $result = $db1->scan(array(
        'TableName' => $table,
        'Limit' => $limit,
        'Select' => 'ALL_ATTRIBUTES'                
     ),
    array('limit' => $limit),
  );
    return $result['Items'];
}

$getobj = scanAllData('slots',3,$dynamodb);


//echo sizeof($getobj);
//echo "<pre>";
//  print_r($getobj);
// echo "</pre>";
//echo "<meta http-equiv='refresh' content='3'>";
//$s1 = json_encode($getobj);
//print $s1;
echo "<br>";
$s2 = 1;
echo "<table>
<tr>
    <th>Slot Number</th>
    <th>Status</th>
  </tr>";
foreach($getobj as $key => $value){
   echo"<tr>";
   echo "<td>";
   echo $s2 . " </td> ";
   echo "<td>";
   print_r($value['payload']['M']['status']['S']);
   echo"</td>";
   echo"</tr>";
	$s2 = $s2+1;
}
echo "</table>";



$dynamodb1 = DynamoDbClient::factory(array(
    'credentials' => array(
        'key'    => 'AKIAWKLX2HYTBDKOLITP',
        'secret' => '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'
    ),'region' => 'us-east-1',
	'version' => 'latest'
));
//    echo "Getting data from sensor "."<br>";

$result1 = $dynamodb1->describeTable(array(
    'TableName' => 'Vehicle_details'
));

// The result of an operation can be used like an array

function scanAllData1($table,$db1){

  $result1 = $db1->scan(array(
        'TableName' => $table,
        'Select' => 'ALL_ATTRIBUTES'                
     ),
  );
    return $result1['Items'];
}

$getobj = scanAllData1('Vehicle_details',$dynamodb);
function writeMsg5($getobj) {
$total_enter_vehicle_count = 0;
	
  foreach($getobj as $key => $value){		
	$total_enter_vehicle_count = $total_enter_vehicle_count + 1;
	

}
return $total_enter_vehicle_count;

}
$total_vehicles = writeMsg5($getobj);


echo "<h3>"."Total Car Records: ".$total_vehicles . "</h3>";


//echo sizeof($getobj);
//echo "<pre>";
//  print_r($getobj);
// echo "</pre>";
//echo "<meta http-equiv='refresh' content='3'>";
//$s1 = json_encode($getobj);
//print $s1;
echo "<br>";
$s2 = 1;
$today_enter_vehicle_count = 0;
$date = date('Y-m-d');
echo "<table>
<tr>
    <th>Vehicle Entry Number</th>
    <th>Vehicle Registration Number</th>
	<th>Entry Time</th>
	<th>Exit Time</th>
	<th>Entry Date</th>
  </tr>";
foreach($getobj as $key => $value){
   echo"<tr>";
   echo "<td>";
   echo $s2 . " </td> ";
   echo "<td>";
   print_r($value['number_plate_text']['S']);
   echo"</td>";

   echo "<td>";
   print_r($value['Entry_time']['S']);
	   echo"</td>";

   echo "<td>";
   print_r($value['Exit_time']['S']);
   echo"</td>";

   echo "<td>";
   print_r($value['Entry_date']['S']);
	
   echo"</td>";




   echo"</tr>";
	
	$s2 = $s2+1;

}
echo "</table>";

function writeMsg($getobj) {
$today_enter_vehicle_count = 0;
	$date = date('Y-m-d');
  foreach($getobj as $key => $value){
	$date1 =strval($value['Entry_date']['S']);
	if($date == $date1 ){
		$today_enter_vehicle_count = $today_enter_vehicle_count + 1;
	}

}
echo $today_enter_vehicle_count;

}

function writeMsg1($getobj) {
$profit = 0;
	
  foreach($getobj as $key => $value){
		$profit = $profit + 80;
	

}
echo $profit;

}
function writeMsg2($getobj) {
$car_parked_in = 0;
	
  foreach($getobj as $key => $value){
	$date1 =strval($value['Exit_time']['S']);
	if($date1 == '0' ){
		$car_parked_in = $car_parked_in + 1;
	}

}
echo $car_parked_in;

}




?>


 <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">
                    
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-1">
                                        <i class="pe-7s-car"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"></span></div>
                                            <div class="stat-heading">Todays Vehicle Entries <span class="bolded"><?php echo writeMsg($getobj) ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                       
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-2">
                                        <i class="pe-7s-car"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"></span></div>
                                            <div class="stat-heading">Total revenue <span class="bolded"><?php echo writeMsg1($getobj) ?></span> RS</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-3">
                                        <i class="pe-7s-car"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"></span></div>
                                            <div class="stat-heading">Total Cars Parked in <span class="bolded"><?php echo writeMsg2($getobj) ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-five">
                                    <div class="stat-icon dib flat-color-4">
                                        <i class="pe-7s-car"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="text-left dib">
                                            <div class="stat-text"><span class="count"></span></div>
                                            <div class="stat-heading">Total Vehicle Entries <span class="bolded"><?php echo $total_vehicles ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Widgets -->
               
            </div>


</body>
</html>
