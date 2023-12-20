<?php 
session_start();
require './connection.php';
$type = "type";
$uid  = "uid";
$pass = "pass";

if( isPost($type) && isPost($uid) && isPost($pass) )
{
$_SESSION[$type] = post($type);
$_SESSION[$uid]  = post($uid);
$_SESSION[$pass] = md5(post($pass));
}

if( isSession($type) && isSession($uid) && isSession($pass) )
{
$type = session($type);
$uid  = session($uid);
$pass = session($pass);
}
else
header("Location: ../Views/index.php");

$sql = "SELECT type FROM login where uname='{$uid}' and pass='{$pass}' and type='{$type}' and active=1";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
	if($type=="1")
	header("Location: ../Views/admin.php?item=1");
	else if($type=="2")
	header("Location: ../Views/user.php?item=1");
	else if($type=="4")
	header("Location: ../Views/viewer.php?item=1");
	else
	header("Location: ./logout.php");
}
else
{
session_unset();
session_destroy();
header("Location: ../Views/index.php?err");
}
?>
