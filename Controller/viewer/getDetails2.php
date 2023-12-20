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
	
	$onTime   = "--";
	$offTime  = "--";
	$Bfault   = "--";
	$Pfault   = "--";
	$Lfault   = "--";
	$LfaultD  = "--";
	$LfaultT  = "--";
	$fault    = "--";
	$resolved = "--";
	$flag     = "--";
	$lastTime = "--";

	$sql = "SELECT time FROM _g_data where device='{$imei}' and v11 LIKE '_______1' and v12 LIKE '_______1' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		$onTime = $row["time"];
	}
	$sql = "SELECT time FROM _g_data where device='{$imei}' and v11 LIKE '_______0' and v12 LIKE '_______1' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		$offTime = $row["time"];
	}
	$sql = "SELECT time FROM _g_data where device='{$imei}' and v11 LIKE '___1____' and v12 LIKE '___1____' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		$Bfault = $row["time"];
	}
	$sql = "SELECT time FROM _g_data where device='{$imei}' and v11 LIKE '__1_____' and v12 LIKE '__1_____' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		$Pfault = $row["time"];
	}
	$sql = "SELECT time FROM _g_data where device='{$imei}' and v11 LIKE '____1___' and v12 LIKE '____1___' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		//$Lfault = $row["time"];
		$Lfault = $row["time"];
		$LfaultD = explode(" ",$row["time"])[0];
		$LfaultT = explode(" ",$row["time"])[1];
	}
	$sql = "SELECT time FROM _g_data where device='{$imei}' and ( ( v11 LIKE '___1____' and v12 LIKE '___1____' ) OR ( v11 LIKE '__1_____' and v12 LIKE '__1_____' ) OR ( v11 LIKE '____1___' and v12 LIKE '____1___' ) ) ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		$fault  = $row["time"];
	}
	//$sql = "SELECT time FROM _g_data where device='{$imei}' and v11 LIKE '___000__' ORDER BY id DESC LIMIT 1";
	$sql = "SELECT time FROM _g_data where device='{$imei}' and v11 LIKE '__000___' and ( v12 LIKE '__001___' OR v12 LIKE '__010___' OR v12 LIKE '__011___' OR v12 LIKE '__100___' OR v12 LIKE '__101___' OR v12 LIKE '__110___' OR v12 LIKE '__111___' ) ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		$resolved = $row["time"];
	}
	$sql = "SELECT v11,time FROM _g_data where device='{$imei}' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		$flag      = $row["v11"];
		$lastTime = $row["time"];
	}

	
	$luminary_qr = "--";
	$battery_qr  = "--";
	$panel_qr    = "--";
	$latlng      = "--";
	$remark      = "--";
	$updated_by  = "--";
	$installTime = "--";
	
	$sql = "SELECT * FROM _f_device where dev_id='{$imei}' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		$luminary_qr = $row["luminary_qr"];
		$battery_qr = $row["battery_qr"];
		$panel_qr = $row["panel_qr"];
		$locationLatLng = $row["lat"].",".$row["lng"];
		$remark = $row["remark"];
		$updated_by = $row["updated_by"];
		$installTime = $row["time"];
	}
	
	echo '{"onTime":"'.$onTime.'","offTime":"'.$offTime.'","Bfault":"'.$Bfault.'","Pfault":"'.$Pfault.'","Lfault":"'.$Lfault.'","LfaultD":"'.$LfaultD.'","LfaultT":"'.$LfaultT.'","fault":"'.$fault.'","resolved":"'.$resolved.'","flag":"'.$flag.'","luminary_qr":"'.$luminary_qr.'","battery_qr":"'.$battery_qr.'","panel_qr":"'.$panel_qr.'","locationLatLng":"'.$locationLatLng.'","remark":"'.$remark.'","updated_by":"'.$updated_by.'","installTime":"'.$installTime.'","lastTime":"'.$lastTime.'"}';
}
?>