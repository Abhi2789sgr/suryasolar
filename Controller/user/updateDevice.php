<?php
session_start();
require '../connection.php';
if( isSession("uid") && isSession("pass") )
{
    $uid  = session("uid");
    $pass = session("pass");
} else {
    header("Location: index.php");
}

$sql = "SELECT id FROM login where uname='{$uid}' and pass='{$pass}' and type='2' and active=1";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
	if(isset($_POST['id']) && isset($_POST['branch'])){

        $tree =array("_g_data", "_f_device", "_e_ward", "_d_panchayat", "_c_block", "_b_district", "_a_project");

        $branchID = $_POST['branch'];
        $branch = $tree[$branchID];
		$updateQuery = "UPDATE ".$branch." SET name ='".$_POST['name']."' WHERE id = ".intval($_POST['id']);
		if ($conn->query($updateQuery) === TRUE){
			echo "1";
		}else{
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
