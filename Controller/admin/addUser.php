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
	$id = $row["id"];
	
	$tree = array("_a_project", "_b_district", "_c_block", "_d_panchayat", "_e_ward");
	
	$uname  = "uname";
	$name   = "name";
	$email  = "email";
	$mob1   = "mob1";
	$mob2   = "mob2";
	$pass   = "pass";
	$type   = "type";
	$branch = "branch";
	$branchValue = "branchValue";

	if( isPost($uname) && isPost($name) && isPost($email) && isPost($pass) && isPost($type) && isPost($branch) && isPost($branchValue))
	{
		$uname  = post($uname);
		$name   = post($name);
		$email  = post($email);
		$mob1   = post($mob1);
		$mob2   = post($mob2);
		$pass   = md5(post($pass));
		$type   = post($type);
		$branch = post($branch);
		$branchValue = post($branchValue);
		// $fileName = post($file);
		// $fileExtesion = explode(".", $fileName);
		// $extName = $fileExtesion[count($fileExtesion) - 1];
		// $folder1 = '../../upload/image/image_'.$uname . "." . $extName;
		// $tempFile = $_FILES['tmp_name'];

		if (isset($_FILES['file'])) {
			$file = $_FILES['file'];
			$tempFile =$file['tmp_name'];
			$tempName = $file['name'];
			$fileExtesion = explode(".", $tempName);
			$extName = $fileExtesion[count($fileExtesion) - 1];
			$targetDir = '../../upload/image/' .$uname .".".$extName ;
			// $folder1 = $targetDir . $fileName;
		}
		$sql = "SELECT id FROM login where uname='{$uname}'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0){
			echo "2";
		} else if (isset($branch) && isset($branchValue)){
			if(move_uploaded_file($tempFile ,$targetDir)){
				$sql = "INSERT INTO login (uname,name,email,mob1,mob2,pass,type,branch,branch_value,added_by,profile_pic) VALUES ('{$uname}','{$name}','{$email}','{$mob1}','{$mob2}','{$pass}','{$type}','{$branch}','{$branchValue}','{$id}','{$targetDir}')";

				if ($conn->query($sql) === TRUE){
					echo "1";
				}
			}else {
				echo "5";
			}
		} else {
			echo "3";
		}
				
	} else {
		echo "4";
	}
}else{
session_unset();
session_destroy();
header("Location: ../Views/index.php?err");
}
?>
