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
	
	$tree = array("_a_project", "_b_district", "_c_block", "_d_panchayat", "_e_ward");
	
	$type   = "type";
	$name   = "name";
	$parent = "parent";
	
	if( isPost($type) && isPost($name) && isPost($parent) )
	{
		$type   = post($type);
		$name   = post($name);
		$parent = post($parent);
	
		$sql = "INSERT INTO ".$tree[$type]." (name,parent) VALUES('{$name}','{$parent}')";
		if ($conn->query($sql) === TRUE)
			echo "1";
		else
			echo "2";
	
	}
}
else
{
session_unset();
session_destroy();
header("Location: ../Views/index.php?err");
}
?>