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
	$entity        = "entity";
	
	if( isGet($branch_global) && isGet($id_global) && isGet($entity) )
	{
		$branch_global = get($branch_global);
		$id_global     = get($id_global);
		$entity        = get($entity);
		if($id_global=="") $id_global="1";
		if($branch_global >7 || $branch_global < 2)
		{
			echo "2";
		}
		else
		{
			$sql = "";
			$entity = explode("$$",$entity);
			for($i=1;$i<count($entity);$i++)
			$sql .= "INSERT INTO ".$tree[$branch_global-1]." (name,parent) VALUES('{$entity[$i]}','{$id_global}');";
			if ($conn->multi_query($sql) === TRUE)
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