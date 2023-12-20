<?php 
header("Content-Type: application/json; charset=UTF-8");
session_start();
require './connection.php';
if( isSession("uid") && isSession("pass") )
{
$uid  = session("uid");
$pass = session("pass");
}
else
header("Location: index.php");

if($uid=="admin")
$sql = "SELECT name,dev_id,lat,lng FROM _f_device where TRUE LIMIT 200";
else
{
$branch = 6;
$branch_value = 0;
$tree = array("_g_data", "_f_device", "_e_ward", "_d_panchayat", "_c_block", "_b_district", "_a_project");
$sql = "SELECT branch,branch_value from login WHERE uname='".$uid."'";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
$row = $result->fetch_assoc();
$branch = explode("_",$tree[$row["branch"]])[2];
$branch_value = $row["branch_value"];
}
$sql = "SELECT name,dev_id,lat,lng FROM _f_device where ".$branch."=".$branch_value;
}
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
	$outp = "";
	while($row = $result->fetch_assoc())
	{
		if ($outp != "") {$outp .= ",";}
		
		$outp .= '{"IMEI":"'. $row["dev_id"]. '",';
		$outp .= '"name":"'.$row["name"].'",';
		$outp .= '"lat":"'.$row["lat"].'",';
		$outp .= '"lng":"'.$row["lng"].'"}';
	}
	$outp ='{"result":['.$outp.']}';
	echo($outp);
}
else
{
	$outp = '{"IMEI":"--","name":"--","lat":"--","lng":"--"}';
	echo '{"result":['.$outp.']}';
}
?>
