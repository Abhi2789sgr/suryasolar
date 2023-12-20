<?php 
session_start();

$name		= "file";
$q			= $_GET["q"];
if ($q=="") die();

require './connection.php';
if( isSession("uid") && isSession("pass") )
{
$uid  = session("uid");
$pass = session("pass");
}
else
header("Location: index.php");

$chk=1;
$data = "";
$sql = "SELECT id FROM login where uname='{$uid}' and pass='{$pass}'";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
	$sql = "SELECT id,v1,v2,v3,v4,v5,v6,v7,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18,v19,v20,time FROM _g_data where device='".$q."'";
	$result = $conn->query($sql);
	if($result->num_rows > 0)
	{
		echo "Device,,".$name.'
IMEI,,="'.$q.'"

Time and Date,Battery Percent,Battery Voltage,Battery Current,Battery Power,Solar Voltage,Solar Current,Solar Power,SSL V,SSl A,SSL P,Full Working Minutes,Dim Working Minutes,Total Working Hour,kWh,Total kWh,System Status
';
		while($row = $result->fetch_assoc())
		{
		  $systemStatus = "0";
		  $lastFourBytes = substr($row["v11"], 3, 3);
		  if(intval($lastFourBytes) > 0){
		  	$systemStatus = "1";
		  }
		  $data=$row["time"].",".$row["v1"].",".$row["v2"].",".$row["v3"].",".$row["v4"].",".$row["v5"].",".$row["v6"].",".$row["v7"].",".$row["v8"].",".$row["v9"].",".$row["v10"].",".$row["v14"].",".$row["v15"].",".$row["v16"].",".$row["v17"].",".$row["v18"].",".$systemStatus."
".$data;
		}
	}
	else
	$chk = 0;
}
else
$chk = 0;

if($chk==0)
echo "<script>alert('Something Wrong');window.location.assign('index.php');</script>";
else
{
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="'.$name.'-'.$q.'.csv"');
echo $data; exit();
}

$conn->close();
?>
