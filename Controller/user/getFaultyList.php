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
	$outp = "";
	while($row = $result->fetch_assoc())
	{
		$sql2 = "SELECT v11, time FROM _g_data where device='".$row["dev_id"]."' ORDER BY id DESC LIMIT 1";
		$result2 = $conn->query($sql2);
		if ($result2->num_rows > 0)
		{
			$row2 = $result2->fetch_assoc();
			$v11 = $row2["v11"];
			if(strlen($v11)!=8) $v11 = "00000000";
			if($v11[2]=="1" || $v11[3]=="1" || $v11[4]=="1")
			{
				if ($outp != "") {$outp .= ",";}
				$outp .= '{"IMEI":"'.$row["dev_id"].'","Name":"'.$row["name"].'","Time":"'.$row2["time"].'"}';
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