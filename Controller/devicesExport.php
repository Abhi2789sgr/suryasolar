<?php
require './connection.php';

$condition = "";
if(isset($_GET['project'])){
	$condition .= " WHERE project = ".$_GET['project'];
}

if(isset($_GET['district'])){
	$condition .= " AND district = ".$_GET['district'];
}

if(isset($_GET['block'])){
	$condition .= " AND block = ".$_GET['block'];
}

if(isset($_GET['panchayat'])){
	$condition .= " AND panchayat = ".$_GET['panchayat'];
}

if(isset($_GET['ward'])){
	$condition .= " AND ward = ".$_GET['ward'];
}

$dataSql = "SELECT `id`,`dev_id`,`name`,`ward`,`panchayat`,`block`,`district`,`project`,`luminary_qr`,`battery_qr`,`panel_qr`,`lat`,`lng`,`remark`,`updated_by`,`time` FROM _f_device".$condition;

$dataResult = $conn->query($dataSql);

$locDataArr["project"] = array();
$locDataArr["district"] = array();
$locDataArr["block"] = array();
$locDataArr["panchayat"] = array();
$locDataArr["ward"] = array();
$devData = array();
while($deviceRow = $dataResult->fetch_assoc()){
	if(!in_array($deviceRow['project'], $locDataArr['project'])){
		$locDataArr['project'][] =  $deviceRow['project'];
	}
	if(!in_array($deviceRow['district'], $locDataArr['district'])){
		$locDataArr["district"][] = $deviceRow['district'];
	}
	if(!in_array($deviceRow['block'], $locDataArr['block'])){
		$locDataArr["block"][] = $deviceRow['block'];
	}
	if(!in_array($deviceRow['panchayat'], $locDataArr['panchayat'])){
		$locDataArr["panchayat"][] = $deviceRow['panchayat'];
	}
	if(!in_array($deviceRow['ward'], $locDataArr['ward'])){
		$locDataArr["ward"][] = $deviceRow['ward'];
	}
	$devData[] = $deviceRow;
}

$projectStr = "'".implode("','", $locDataArr['project'])."'";
$distStr = "'".implode("','", $locDataArr['district'])."'";
$blockStr = "'".implode("','", $locDataArr['block'])."'";
$panchStr = "'".implode("','", $locDataArr['panchayat'])."'";
$wardStr = "'".implode("','", $locDataArr['ward'])."'";

$sqlProject = "SELECT * FROM _a_project WHERE id IN (".$projectStr.")";
$projectResult = $conn->query($sqlProject);
$projectArr = array();
if($projectResult->num_rows > 0){
	while ($row = $projectResult->fetch_assoc()) {
		$projectArr[$row['id']] = $row['name'];
	}
}

$sqlDist = "SELECT * FROM _b_district WHERE id IN (".$distStr.")";
$distResult = $conn->query($sqlDist);
$distArr = array();
if ($distResult->num_rows > 0) {
	while ($row = $distResult->fetch_assoc()) {
		$distArr[$row['id']] = $row['name'];
	}
}

$sqlBlock = "SELECT * FROM _c_block where id IN (".$blockStr.")";
$blockResult = $conn->query($sqlBlock);
$blockArr = array();
if ($distResult->num_rows > 0) {
	while ($row = $blockResult->fetch_assoc()) {
		$blockArr[$row['id']] = $row['name'];
	}
}

$sqlPanchayat = "SELECT * FROM _d_panchayat WHERE id IN (".$panchStr.")";
$panchResult = $conn->query($sqlPanchayat);
$panchArr = array();
if ($panchResult->num_rows > 0) {
	while ($row = $panchResult->fetch_assoc()) {
		$panchArr[$row['id']] = $row['name'];
	}
}

$sqlWard = "SELECT * FROM _e_ward WHERE id IN (".$wardStr.")";
$wardResult = $conn->query($sqlWard);
$wardArr = array();
if ($wardResult->num_rows > 0) {
	while ($row = $wardResult->fetch_assoc()) {
		$wardArr[$row['id']] = $row['name'];
	}
}

$csvData = "";

echo 'IMEI,Pole Id,Project Name,District,Block,Panchayat,Ward,Luminary QR,Battery QR,Panel QR,Latitude,Longitude,Remark,Installed By,Date,Time
';

foreach ($devData as $dRow){
	$projeName = " ";
	if(isset($projectArr[$dRow['project']])){
		$projeName = $projectArr[$dRow['project']];
	}
	$distName = " ";
	if(isset($distArr[$dRow['district']])){
		$distName = $distArr[$dRow['district']];
	}
	$blockName = " ";
	if(isset($blockArr[$dRow['block']])){
		$blockName = $blockArr[$dRow['block']];
	}
	$panchName = " ";
	if(isset($panchArr[$dRow['panchayat']])){
		$panchName = $panchArr[$dRow['panchayat']];
	}
	$wardName = " ";
	if(isset($wardArr[$dRow['ward']])){
		$wardName = $wardArr[$dRow['ward']];
	}

	$dateTimeArr = explode(" ", $dRow["time"]);
	$newPoleId = substr($projeName, 0, 3) .'/'. substr($distName, 0, 3) .'/'. substr($blockName, 0, 3) .'/'. substr($panchName, 0, 3) .'/'. substr($wardName, 0, 3) .'/' .$dRow['name'];

	$csvData = $dRow['dev_id'].",".$dRow['name'].",".$projeName.",".$distName.",".$blockName.",".$panchName.",".$wardName.",".$dRow['luminary_qr'].",".$dRow['battery_qr'].",".$dRow['panel_qr'].",".$dRow['lat'].",".$dRow['lng'].",".$dRow['remark'].",".$dRow['updated_by'].",".$dateTimeArr[0].",".$dateTimeArr[1]."
".$csvData;

}

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="report.csv"');
echo $csvData;
exit();
?>
