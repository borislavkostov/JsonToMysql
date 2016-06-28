<?php
    require("db_info.php");
$conn = mysql_connect("localhost", $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
$str = file_get_contents('events.json');
$json = json_decode($str, true);
$last = count($json['events']['event']) - 1;
mysql_select_db("wordpress") or die(mysql_error()); 
foreach ($json['events']['event'] as $i => $row)
{
    $isFirst = ($i == 0);
    $isLast = ($i == $last);

    $latitude=$row['latitude'];
    $longitude=$row['longitude'];
	echo $latitude;
	mysql_select_db("wordpress") or die(mysql_error()); 
	$sql = "INSERT INTO `markers` (`latitude`, `longitude`) 
	VALUES ($latitude,$longitude);";
$data = mysql_query($sql);
}
?>
