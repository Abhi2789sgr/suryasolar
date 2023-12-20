<?php
require './connection.php';
if(isset($_GET['project_id'])){
	$sql = "SELECT id,dev_id FROM _f_device WHERE project = '".$_GET['project_id']."'";
}
if(isset($_GET['district_id'])){
	$sql .= " AND district = '".$_GET["district_id"]."'";
}
if(isset($_GET['block_id'])){
	$sql .= " AND block = '".$_GET["block_id"]."'";
}
if(isset($_GET['panchayat_id'])){
	$sql .= " AND panchayat = '".$_GET["panchayat_id"]."'";
}
if(isset($_GET['ward_id'])){
	$sql .= " AND ward = '".$_GET["ward_id"]."'";
}

$final_result = array();
$device_result = "";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
	$final_result[] = $row;
	$device_result .= "'".$row["dev_id"]."',";
}

$fin_devs = substr($device_result, 0, -1);

$dataSql = "SELECT * FROM _g_data WHERE id IN (SELECT MAX(id) FROM _g_data WHERE device IN (".$fin_devs.") GROUP BY device)";

$dataResult = $conn->query($dataSql);

$csvData = "";

$finalDataRes = array();

echo 'IMEI,Time and Date,Battery Percent,Battery Voltage,BatteryCurrent,Battery Power,Solar Voltage,Solar Current,Solar Power,SSL V,SSl A,SSL P,Full Working Minutes,Dim Working Minutes,Total Working Hour,kWh,Total kWh,System Status
';

while ($dRow = $dataResult->fetch_assoc()){

	$systemStatus = "0";
	$lastFourBytes = substr($dRow["v11"], 3, 3);
	if(intval($lastFourBytes) > 0){
		$systemStatus = "1";
	}

	$finalDataRes[] = $dRow;
	$csvData=$dRow['device'].",".$dRow["time"].",".$dRow["v1"].",".$dRow["v2"].",".$dRow["v3"].",".$dRow["v4"].",".$dRow["v5"].",".$dRow["v6"].",".$dRow["v7"].",".$dRow["v8"].",".$dRow["v9"].",".$dRow["v10"].",".$dRow["v14"].",".$dRow["v15"].",".$dRow["v16"].",".$dRow["v17"].",".$dRow["v18"].",".$systemStatus."
".$csvData;
}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="report.csv"');
echo $csvData; exit();

?>