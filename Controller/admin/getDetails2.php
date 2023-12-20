<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
require '../../Controller/connection.php';
if (isSession("uid") && isSession("pass")) {
	$uid  = session("uid");
	$pass = session("pass");
} else
	header("Location: index.php");

if (isGet("imei")) {
	$imei = get("imei");

	$onTime   = "--";
	$offTime  = "--";

	$sql = "SELECT * FROM _j_light_status where device='{$imei}' ORDER BY id DESC LIMIT 2";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			if ($row['status'] == 1) {
				$onTime = $row["created_at"];
			} else {
				$offTime = $row["created_at"];
			}
		}
	}

	$Pfault = "--";
	$PfaultRt = "--";
	$PfaultRs = "--";
	$Lfault = "--";
	$LfaultRt = "--";
	$LfaultRtD = "--";
	$LfaultRtT = "--";
	$LfaultRs = "--";
	$Bfault = "--";
	$BfaultRt = "--";
	$BfaultRs = "--";

	$sql = "SELECT * FROM _h_fault_data where device='{$imei}' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();

		// DT stands for date and time,D stands date,and T stands time
		$Pfault  = $row['panel_fault'];
		if($row['panel_fault_reported'] != ""){
		$PfaultRt = $row['panel_fault_reported'];}
		$PfaultRs = $row['panel_fault_resolved'];
		$Lfault = $row["luminary_fault"];
		$LfaultRt = $row['luminary_fault_reported'];
		$LfaultRtD = explode(" ", $row["luminary_fault_reported"])[0];
		$LfaultRtT = explode(" ", $row["luminary_fault_reported"])[1];
		$LfaultRs = $row['luminary_fault_resolved'];
		$Bfault = $row['battery_fault'];
		if($row['battery_fault_reported'] != ""){
		$BfaultRt = $row['battery_fault_reported'];}

		$BfaultRs = $row['battery_fault_resolved'];
	}

	$fault    = "--";
	$resolved = "--";
	$flag     = "--";
	$lastTime = "--";

	$luminary_qr = "--";
	$battery_qr  = "--";
	$panel_qr    = "--";
	$latlng      = "--";
	$remark      = "--";
	$updated_by  = "--";
	$installTime = "--";

	$sql = "SELECT * FROM _f_device where dev_id='{$imei}' ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$luminary_qr = $row["luminary_qr"];
		$battery_qr = $row["battery_qr"];
		$panel_qr = $row["panel_qr"];
		$locationLatLng = $row["lat"] . "," . $row["lng"];
		$remark = $row["remark"];
		$updated_by = $row["updated_by"];
		$installTime = $row["time"];
	}

	echo '{"onTime":"' . $onTime . '","offTime":"' . $offTime . '","battery-fault":"' . $Bfault . '","Bfault":"' . $BfaultRt . '","BfaultRs":"' . $BfaultRs . '","panel-fault":"' . $Pfault . '","Pfault":"' . $PfaultRt . '","PfaultRs":"' . $PfaultRs . '","luminary-fault":"' . $Lfault . '","Lfault":"' . $LfaultRt . '","LfaultRs":"' . $LfaultRs . '","LfaultRtD":"' . $LfaultRtD . '","LfaultRtT":"' . $LfaultRtT . '","fault":"' . $fault . '","resolved":"' . $resolved . '","flag":"' . $flag . '","luminary_qr":"' . $luminary_qr . '","battery_qr":"' . $battery_qr . '","panel_qr":"' . $panel_qr . '","locationLatLng":"' . $locationLatLng . '","remark":"' . $remark . '","updated_by":"' . $updated_by . '","installTime":"' . $installTime . '","lastTime":"' . $lastTime . '"}';
}
?>
