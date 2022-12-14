<!DOCTYPE html>
<html>
<head>

<style type="text/css">
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
.header {
  background-color: #f1f1f1;
  padding: 20px;
  text-align: center;
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
h2{
text-align: center;
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
body {
  margin: 0;
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
$result1 = $dynamodb->describeTable(array(
    'TableName' => 'Vehicle_details'
));

// The result of an operation can be used like an array
//$total_vehicles = $result1['Table']['ItemCount'];


function scanAllData($table,$db1){

  $result1 = $db1->scan(array(
        'TableName' => $table,
        'Select' => 'ALL_ATTRIBUTES'                
     ),
  );
    return $result1['Items'];
}

$getobj = scanAllData('Vehicle_details',$dynamodb);
function writeMsg5($getobj) {
$total_enter_vehicle_count = 0;
	
  foreach($getobj as $key => $value){		
	$total_enter_vehicle_count = $total_enter_vehicle_count + 1;
	

}
return $total_enter_vehicle_count;

}
$total_vehicles = writeMsg5($getobj);
echo "<h2>"."Total Car Records: ".$total_vehicles . "</h2>";

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

?>

</body>
</html>