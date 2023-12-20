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
header("Location: ../../index.php");

$sql = "SELECT name,dev_id FROM _f_device where active=1";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
	$tempDevArr = array();
	$outp = "";
	while($row = $result->fetch_assoc())
	{
		$tempDevArr[$row["dev_id"]] = $row["name"];

	}

	$sql2 = "SELECT * FROM _h_fault_data WHERE panel_fault = 1 OR luminary_fault = 1 OR battery_fault = 1";
	$result2 = $conn->query($sql2);
	if($result2->num_rows > 0){
		$faultinmilli = 0;
		$faulttimereported = "";
		while($row2 = $result2->fetch_assoc()){
			if($row2['luminary_fault_reported'] != null){
				$temptime = strtotime($row2['luminary_fault_reported']) * 1000;
				if($temptime  > $faultinmilli){
					$faultinmilli = $temptime;
					$faulttimereported = $row2['luminary_fault_reported'];
				} 
			}
			if($row2['panel_fault_reported'] != null){
				$temptime = strtotime($row2['panel_fault_reported']) * 1000;
				if($temptime  > $faultinmilli){
					$faultinmilli = $temptime;
					$faulttimereported = $row2['panel_fault_reported'];
				} 
			}
			if($row2['battery_fault_reported'] != null){
				$temptime = strtotime($row2['battery_fault_reported']) * 1000;
				if($temptime  > $faultinmilli){
					$faultinmilli = $temptime;
					$faulttimereported = $row2['battery_fault_reported'];
				} 
			}

			
			if(isset($tempDevArr[$row2["device"]])){
				if ($outp != "") {
					$outp .= ",";
				}
				$outp .= '{"IMEI":"'.$row2["device"].'","Name":"'.$tempDevArr[$row2["device"]].'","Time":"'.$faulttimereported.'"}';
			}
		}
	}
	
	$outp = '{"result":['.$outp.']}';
	echo($outp);
}
else
{
	echo '{"result":[{"IMEI":"Empty","Name":"Empty","Time":"No Faulty Device"}]}';
}
?>
