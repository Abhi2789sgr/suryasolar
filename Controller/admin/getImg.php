<?php 
header("Content-Type: application/json; charset=UTF-8");
session_start();
require '../../Controller/connection.php';
if( isSession("uid") && isSession("pass") )
{
$uid  = session("uid");
$pass = session("pass");
}
else
header("Location: index.php");

if( isGet("imei") )
{
	$imei = get("imei");

	$sql = "SELECT file FROM _f_device where dev_id='{$imei}'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		echo $row["file"];
	}
}
?>