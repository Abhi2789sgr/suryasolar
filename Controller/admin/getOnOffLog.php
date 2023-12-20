<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
require '../../Controller/connection.php';
if (isSession("uid") && isSession("pass")) {
	$uid  = session("uid");
	$pass = session("pass");
} else
	header("Location: index.php");


$offset = 0;
$limit = 10;

if (isset($_GET['limit'])) {
	$limit = intval($_GET['limit']);
}
if (isset($_GET['pageNo'])) {
	$offset = intval($_GET['pageNo']) * $limit;
}

if (isGet("imei")) {
	$imei = get("imei");

	$sql = "SELECT id,status,created_at FROM _j_light_status where device='{$imei}' ORDER BY id  LIMIT $offset,$limit";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$outp = "";

		$i = 0;
		$myArr = array();
		while ($row = $result->fetch_assoc()) {

			//creating date time object
			$var_on= $row["created_at"];
			$var_off="--";
			$on = date_create($row["created_at"]); //get on time
		
			$onDuration = "--";
			$off = "--";
			if ($row = $result->fetch_assoc()) {
				//creating date time object
				$var_off=$row["created_at"];
				$off = date_create($row["created_at"]); //get off time
				$diff = date_diff($on, $off);
				$onDuration = $diff->h . ':' . $diff->i . ':' . $diff->s;
			}
			$myArr[$i] = array($var_on, $var_off, $onDuration);

			$i++;
			
		}

		foreach ($myArr as $row) {

			if ($outp != "") {
				$outp .= ",";
			}
			// echo $row[0];
			// exit;
			$outp .= '{"OnTime":"' . $row[0] . '",';
			$outp .= '"OffTime":"' . $row[1] . '",';
			$outp .= '"OnDuration":"' . $row[2] . '"}';

		}
		$outp = '{"result":[' . $outp . ']}';
		echo ($outp);
		
	} else {
		$outp = '{"OnTime":"--","OffTime":"--","OnDuration":"--"}';
		echo '{"result":[' . $outp . ']}';
	}
}
