<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
require './connection.php';
if (isSession("uid") && isSession("pass")) {
	$uid  = session("uid");
	$pass = session("pass");
} else {
	header("Location: index.php");
}

$offset = 0;
$limit = 50;
$search = "";
if(isset($_GET['search'])){
	$search = $_GET['search'];
}

if (isset($_GET['limit'])) {
	$limit = intval($_GET['limit']);
}
if (isset($_GET['pageNo'])) {
	$offset = intval($_GET['pageNo']) * $limit;
}

if ($uid == "admin") {
	$sql = "SELECT _g_data.id,_g_data.time,dev_id as device,name,v1,v2,v3,v4,v5,v6,v7,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18,v19,v20,lat,lng FROM _f_device left join _g_data on dev_id=device WHERE 1 AND device LIKE '%$search%' ORDER BY _g_data.id DESC LIMIT $offset,$limit";
} else {
	$branch = 6;
	$branch_value = 0;
	$tree = array("_g_data", "_f_device", "_e_ward", "_d_panchayat", "_c_block", "_b_district", "_a_project");
	$sql = "SELECT branch,branch_value from login WHERE uname='" . $uid . "'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$branch = explode("_", $tree[$row["branch"]])[2];
		$branch_value = $row["branch_value"];
	}
	if($search != ""){
		$sql = "SELECT _g_data.id,_g_data.time,dev_id as device,name,v1,v2,v3,v4,v5,v6,v7,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18,v19,v20,lat,lng FROM _f_device left join _g_data on dev_id=device WHERE " . $branch . "=" . $branch_value . " AND device LIKE '%$search%' ORDER BY _g_data.id DESC LIMIT $offset,$limit";
	}else{
		$sql = "SELECT _g_data.id,_g_data.time,dev_id as device,name,v1,v2,v3,v4,v5,v6,v7,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18,v19,v20,lat,lng FROM _f_device left join _g_data on dev_id=device WHERE " . $branch . "=" . $branch_value . " ORDER BY _g_data.id DESC LIMIT $offset,$limit";
	}
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$outp = "";
	while ($row = $result->fetch_assoc()) {
		if ($outp != "") {
			$outp .= ",";
		}

		$latlng = $row["lat"] . "," . $row["id"];

		$outp .= '{"id":"' . $row["id"] . '",';
		$outp .= '"Time":"' . $row["time"] . '",';
		$outp .= '"IMEI":"' . $row["device"] . '",';
		$outp .= '"Pole-ID":"' . $row["name"] . '",';
		$outp .= '"latlng":"' . $latlng . '",';
		$outp .= '"V1":"' . $row["v1"] . '",';
		$outp .= '"V2":"' . $row["v2"] . '",';
		$outp .= '"V3":"' . $row["v3"] . '",';
		$outp .= '"V4":"' . $row["v4"] . '",';
		$outp .= '"V5":"' . $row["v5"] . '",';
		$outp .= '"V6":"' . $row["v6"] . '",';
		$outp .= '"V7":"' . $row["v7"] . '",';
		$outp .= '"V8":"' . $row["v8"] . '",';
		$outp .= '"V9":"' . $row["v9"] . '",';
		$outp .= '"V10":"' . $row["v10"] . '",';

		//$v11 = str_pad(decbin($row["v11"]), 8, 0, STR_PAD_LEFT);
		$v11 = $row["v11"];
		if (strlen($v11) != 8) $v11 = "00000000";
		$outp .= '"V11[2,3,4]":"' . ($v11[2] . $v11[3] . $v11[4] == "000" ? "green" : "red") . '",';
		$outp .= '"V11[2]":"' . ($v11[2] > 0 ? "red" : "green") . '",';
		$outp .= '"V11[3]":"' . ($v11[3] > 0 ? "red" : "green") . '",';
		$outp .= '"V11[4]":"' . ($v11[4] > 0 ? "red" : "green") . '",';
		$outp .= '"V11[5]":"' . ($v11[5] > 0 ? "LOW" : "OK") . '",';
		$outp .= '"V11[6]":"' . ($v11[6] > 0 ? "fa-moon-o w3-text-grey" : "fa-sun-o w3-text-orange") . '",';
		//$outp .= '"V11[5]":"'.($v11[5]>0?"fa-battery-1 w3-text-red":"fa-battery w3-text-green").'",';
		//$outp .= '"V11[7]":"'.($v11[7]>0?"w3-text-orange":"strikethrough w3-text-grey").'",';
		$outp .= '"V11[7]":"' . ($v11[7] > 0 ? "fa-lightbulb-o w3-text-orange" : "fa-lightbulb-o w3-text-grey") . '",';
		/*
		$outp .= '"V11":"'.$row["v11"].'",';
		$outp .= '"V12":"'.$row["v12"].'",';
		$outp .= '"V13":"'.$row["v13"].'",';
		*/
		$outp .= '"V14":"' . hoursandmins($row["v14"], '%02d:%02d') . '",';
		$outp .= '"V15":"' . hoursandmins($row["v15"], '%02d:%02d') . '",';
		$outp .= '"V16":"' . $row["v16"] . '",';
		$outp .= '"V17":"' . $row["v17"] . '",';
		$outp .= '"V18":"' . $row["v18"] . '"}';
	}
	$outp = '{"result":[' . $outp . ']}';
	echo ($outp);
} else {
	$outp = '{"Time":"--","IMEI":"--","Pole-ID":"--","latlng":"--","V1":"--","V2":"--","V3":"--","V4":"--","V5":"--","V6":"--","V7":"--","V8":"--","V9":"--","V10":"--","V11[2,3,4]":"--","V11[2]":"--","V11[3]":"--","V11[4]":"--","V11[5]":"--","V11[6]":"--","V11[7]":"--","V12":"--","V13":"--","V14":"--","V15":"--","V16":"--","V17":"--","V18":"--","V19":"--","V20":"--"}';
	echo '{"result":[' . $outp . ']}';
}
?>
