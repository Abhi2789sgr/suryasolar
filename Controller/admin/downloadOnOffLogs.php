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
	$sql2="";
	if ($imei == 0) {
		if (!empty($_GET["project_id"])) {
			$sql2 .= "_f_device.project=" . $_GET["project_id"];
		}
		if (!empty($_GET['district_id'])) {
			$sql2 .= " AND _f_device.district = " . $_GET["district_id"];
		}
		if (!empty($_GET['block_id'])) {
			$sql2 .= " AND _f_device.block = " . $_GET["block_id"];
		}
		if (!empty($_GET['panchayat_id'])) {
			$sql2 .= " AND _f_device.panchayat = " . $_GET["panchayat_id"] ;
		}
		if (!empty($_GET['ward_id'])) {
			$sql2 .= " AND _f_device.ward = " . $_GET["ward_id"] ;
		}

		$sql = "SELECT _j_light_status.* , _f_device.name FROM _j_light_status INNER JOIN _f_device ON _j_light_status.device=_f_device.dev_id WHERE _j_light_status.device IN(SELECT _f_device.dev_id FROM _f_device WHERE {$sql2}) AND _j_light_status.created_at BETWEEN '{$_GET['startDate']} 12:00:00' AND '{$_GET['endDate']} 12:00:00' ORDER BY _j_light_status.id";
		// {$_GET['ward_id']}
		// {$_GET['panchayat_id']}
		// {$_GET['block_id']} 
	} else {
		// SELECT _j_light_status.* , _f_device.name FROM _j_light_status INNER JOIN _f_device ON _j_light_status.device=_f_device.dev_id WHERE _j_light_status.device IN(SELECT _f_device.dev_id FROM _f_device WHERE _f_device.project=1 AND _f_device.district=26 AND _f_device.block=324 AND _f_device.panchayat=1 AND _f_device.ward=1) AND _j_light_status.created_at BETWEEN '2023-07-01 12:00:00' AND '2023-07-02 12:00:00' ORDER BY _j_light_status.id;

		$sql = "SELECT _j_light_status.* , _f_device.name FROM _j_light_status INNER JOIN _f_device ON _j_light_status.device=_f_device.dev_id WHERE  _j_light_status.device='{$imei}' AND _j_light_status.created_at BETWEEN '{$_GET['startDate']} 12:00:00' AND '{$_GET['endDate']} 12:00:00' ORDER BY _j_light_status.id";
	}
	// echo $sql;
	// exit;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$outp = "";

		$myArr = array();
		while ($row = $result->fetch_assoc()) {

			//creating date time object
			$var_on = $row["created_at"];
			$var_off = "--";
			$on = date_create($row["created_at"]); //get on time
			$poleID = $row["name"];
			$device_imei=$row["device"];
			$onDuration = "--";
			$off = "--";
			if ($row = $result->fetch_assoc()) {
				//creating date time object
				$var_off = $row["created_at"];
				$off = date_create($row["created_at"]); //get off time
				$diff = date_diff($on, $off);
				$onDuration = $diff->h . ':' . $diff->i . ':' . $diff->s;
			}
			$myArr[$i] = array($var_on, $var_off, $onDuration, $poleID,$device_imei);

		}

		foreach ($myArr as $row) {

			if ($outp != "") {
				$outp .= ",";
			}
			$outp .= '{"OnTime":"' . $row[0] . '",';
			$outp .= '"OffTime":"' . $row[1] . '",';
			$outp .= '"PoleID":"' . $row[3] . '",';
			$outp .= '"dev_imei":"' . $row[4] . '",';
			$outp .= '"OnDuration":"' . $row[2] . '"}';
		}
		$outp = '{"result":[' . $outp . ']}';
		echo ($outp);
	} else {
		$outp = '{"OnTime":"--","OffTime":"--","PoleID":"--","dev_imei":"--","OnDuration":"--"}';
		echo '{"result":[' . $outp . ']}';
	}
}
