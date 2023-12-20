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

	$sql = "SELECT * FROM _g_data where device='{$imei}' ORDER BY id DESC LIMIT 200";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$outp = "";
		while($row = $result->fetch_assoc())
		{
			if ($outp != "") {$outp .= ",";}
			
			$outp .= '{"Time":"'.$row["time"].'",';
			$outp .= '"V1":"'. $row["v1"]. '",';
			$outp .= '"V2":"'. $row["v2"]. '",';
			$outp .= '"V3":"'. $row["v3"]. '",';
			$outp .= '"V4":"'. $row["v4"]. '",';
			$outp .= '"V5":"'. $row["v5"]. '",';
			$outp .= '"V6":"'. $row["v6"]. '",';
			$outp .= '"V7":"'. $row["v7"]. '",';
			$outp .= '"V8":"'. $row["v8"]. '",';
			$outp .= '"V9":"'. $row["v9"]. '",';
			$outp .= '"V10":"'.$row["v10"].'",';
			
			//$v11 = str_pad(decbin($row["v11"]), 8, 0, STR_PAD_LEFT);
			$v11 = $row["v11"];
			if(strlen($v11)!=8) $v11 = "00000000";
			$outp .= '"V11[2,3,4]":"'.($v11[2].$v11[3].$v11[4]=="000"?"green":"red").'",';
			$outp .= '"V11[2]":"'.($v11[2]>0?"red":"green").'",';
			$outp .= '"V11[3]":"'.($v11[3]>0?"red":"green").'",';
			$outp .= '"V11[4]":"'.($v11[4]>0?"red":"green").'",';
			$outp .= '"V11[5]":"'.($v11[5]>0?"LOW":"OK").'",';
			$outp .= '"V11[6]":"'.($v11[6]>0?"fa-moon-o w3-text-grey":"fa-sun-o w3-text-orange").'",';
			//$outp .= '"V11[5]":"'.($v11[5]>0?"fa-battery-1 w3-text-red":"fa-battery w3-text-green").'",';
			//$outp .= '"V11[7]":"'.($v11[7]>0?"w3-text-orange":"strikethrough w3-text-grey").'",';
			$outp .= '"V11[7]":"'.($v11[7]>0?"fa-lightbulb-o w3-text-orange":"fa-lightbulb-o w3-text-grey").'",';
			/*
			$outp .= '"V11":"'.$row["v11"].'",';
			$outp .= '"V12":"'.$row["v12"].'",';
			$outp .= '"V13":"'.$row["v13"].'",';
			*/
			$outp .= '"V14":"'.hoursandmins($row["v14"], '%02d:%02d').'",';
			$outp .= '"V15":"'.hoursandmins($row["v15"], '%02d:%02d').'",';
			$outp .= '"V16":"'.$row["v16"].'",';
			$outp .= '"V17":"'.$row["v17"].'",';
			$outp .= '"V18":"'.$row["v18"].'"}';
		}
		$outp ='{"result":['.$outp.']}';
		echo($outp);
	}
	else
	{
		$outp = '{"Time":"--","V1":"--","V2":"--","V3":"--","V4":"--","V5":"--","V6":"--","V7":"--","V8":"--","V9":"--","V10":"--","V11[2,3,4]":"--","V11[2]":"--","V11[3]":"--","V11[4]":"--","V11[5]":"--","V11[6]":"--","V11[7]":"--","V12":"--","V13":"--","V14":"--","V15":"--","V16":"--","V17":"--","V18":"--","V19":"--","V20":"--"}';
		echo '{"result":['.$outp.']}';
	}
}
?>