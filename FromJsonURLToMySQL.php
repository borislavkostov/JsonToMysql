<?php
    require("db_info.php");
$conn = mysql_connect("localhost", $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
$x=4;
for($x=120;$x<220;$x++)
{
$str = file_get_contents("http://api.eventful.com/json/events/search?c=music&app_key=API_KEY&page_number=".$x."&date=Future&callback=processJSONP/");
$json = json_decode($str, true);
//echo '<pre>' . print_r($json, true) . '</pre>';
$last = count($json['events']['event']) - 1;
mysql_select_db("wordpress") or die(mysql_error()); 
foreach ($json['events']['event'] as $i => $row)
{
    $isFirst = ($i == 0);
    $isLast = ($i == $last);
    $id=$row['id'];
    $latitude=$row['latitude'];
    $longitude=$row['longitude'];
    $title=$row['title'];
    $start_time=$row['start_time'];

//echo $start_time;
	//echo $latitude;
	mysql_select_db("wordpress") or die(mysql_error()); 
	$sql = "INSERT INTO `markers` (`id`,`latitude`, `longitude`,`title`,`start_time`) 
	VALUES ('$id','$latitude','$longitude','$title','$start_time');";
$data = mysql_query($sql);
}
}
?>
