<?php 
session_start();
require '../connection.php';
if( isSession("uid") && isSession("pass") )
{
$uid  = session("uid");
$pass = session("pass");
}
else
header("Location: index.php");

$sql = "SELECT id FROM login where uname='{$uid}' and pass='{$pass}' and type='1' and active=1";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
	$row = $result->fetch_assoc();
	
	$tree = array("_g_data", "_f_device", "_e_ward", "_d_panchayat", "_c_block", "_b_district", "_a_project");
	
	$branch_global = "branch_global";
	$id_global     = "id_global";
	$skey          = "skey";
	
	if( isPost($branch_global) && isPost($id_global) && isPost($skey) )
	{
		$branch_global = post($branch_global);
		$id_global     = post($id_global);
		$skey          = post($skey);
		if($id_global=="") $id_global="1";
		if($branch_global >7 || $branch_global < 2 || $skey != $skey_top)
		{
			echo "2";
		}
		else
		{
			$sql = "DELETE FROM ".$tree[$branch_global-1]." WHERE parent = '".$id_global."'";
			if ($conn->query($sql) === TRUE)
				echo "1";
			else
				echo "2";
		}
	
	}
}
else
{
session_unset();
session_destroy();
header("Location: ../Views/index.php?err");
}
?>