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

$sql = "SELECT branch, branch_value FROM login where uname='{$uid}' and pass='{$pass}' and type='4' and active=1";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
	$row = $result->fetch_assoc();
	
	$tree = array("_g_data", "_f_device", "_e_ward", "_d_panchayat", "_c_block", "_b_district", "_a_project");
	
	$branchID = $row["branch"]-1;
	$branch = $tree[$branchID];
	$parent = $row["branch_value"];
	
	if( isGet("branch") && isGet("parent") )
	{
		$branchID = get("branch");
		$branch = $tree[$branchID];
		$parent = get("parent");
	}
	
	$lastData = "";
	$activeData = "";
	if($branch == "_f_device")
	{
		$lastData = ", dev_id";
		$activeData = " and active=1";
	}
	
		$outp = "";
	$sql = "SELECT id, name".$lastData." FROM ".$branch." where parent='{$parent}'".$activeData;
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			$deviceCount = "0";
			if ($outp != "") {$outp .= ",";}
			if(isset($row["dev_id"]))
				$deviceCount = $branchID = $row["dev_id"];
			else
			{
				$sql2 = "SELECT count(id) as id FROM _f_device where active=1 and ".explode("_",$branch)[2]."=".$row["id"];
				$result2 = $conn->query($sql2);
				if ($result2->num_rows > 0)
				{
					$row2 = $result2->fetch_assoc();
					$deviceCount = $row2["id"];
				}
			}
			
			$outp .= '{"Name":"'.$row["name"].'",';
			$outp .= '"ID":"'.$row["id"].'",';
			$outp .= '"DeviceCount":"'.$deviceCount.'",';
			$outp .= '"Branch":"'.$branchID.'"}';
		}
	}
	if($outp == "") $outp = '{"Name": "N/A", "ID": "0", "DeviceCount": "0", "Branch": "'.$branchID.'"}';
		$outp ='{"result":['.$outp.']}';
		echo($outp);
}
else
{
session_unset();
session_destroy();
header("Location: ../Views/index.php?err");
}
?>