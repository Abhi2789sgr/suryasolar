<?php 
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: X-PINGOTHER, Content-Type');
header('Access-Control-Max-Age: 86400');
session_start();

if(isset($_POST["type"]))
{
	require './Controller/connection.php';
	$type = $_POST["type"];
	switch($type)
	{
		case "Login":
			if( isset($_POST["uname"]) && isset($_POST["pass"]) )
			{
				$uname  = $_POST["uname"];
				$pass = md5($_POST["pass"]);
				
				$sql = "SELECT id, branch, branch_value FROM login where uname='{$uname}' and pass='{$pass}' and type='3' and active=1";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$sid = session_id();
					$sql = "UPDATE login SET email='".$sid."' WHERE uname='{$uname}'";
					if ($conn->query($sql) === TRUE){
						echo '{"status":"OK", "detail":"Login Successful !!!", "SID":"'.$sid.'", "branch":"'.$row["branch"].'", "PID":"'.$row["branch_value"].'"}';
					} else {
						echo '{"status":"ERR", "detail":"DB Error"}';
					}
				} else {
					echo '{"status":"ERR", "detail":"Username/Password Missmatch"}';
				}
			} else {
				echo '{"status":"ERR", "detail":"Invalid Parameter"}';
			}
		break;
		
		case "List":
			if( isset($_POST["uname"]) && isset($_POST["SID"]) && isset($_POST["branch"]) && isset($_POST["PID"]) ){
				$sql = "SELECT id FROM login where uname='{$_POST["uname"]}' and  email='{$_POST["SID"]}'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0){
					$tree = array("_g_data", "_f_device", "_e_ward", "_d_panchayat", "_c_block", "_b_district", "_a_project");
					$branch = $_POST["branch"]-1;
					$parent = $_POST["PID"];
					if($branch>6) $branch=6;
					if($branch<2) $branch=1;
					$branch = $tree[$branch];
					
					$sql = "SELECT id, name FROM ".$branch." where parent='{$parent}'";
					$result = $conn->query($sql);
					if ($result->num_rows > 0)
					{
						$outp = "";
						while($row = $result->fetch_assoc())
						{
							if ($outp != "") {
								$outp .= ",";
							}
							$outp .= '{"ID":"'.$row["id"].'",';
							$outp .= '"Name":"'.$row["name"].'"}';
						}
						$outp ='{"status":"OK", "detail":"List Fetched for given PID", "result":['.$outp.']}';
						echo($outp);
					} else {
						echo '{"status":"ERR", "detail":"Zero Records"}';
					}
				} else {
					echo '{"status":"ERR", "detail":"Login Again"}';
				}
			} else {
				echo '{"status":"ERR", "detail":"Invalid Parameter"}';
			}
		break;
		
		case "Add":
			if( isset($_POST["uname"]) && isset($_POST["SID"]) && isset($_POST["pole_id"]) && isset($_POST["ward_id"]) && isset($_POST["panchayat_id"]) && isset($_POST["block_id"]) && isset($_POST["district_id"]) && isset($_POST["luminary_qr"]) && isset($_POST["battery_qr"]) && isset($_POST["panel_qr"]) && isset($_POST["file"]) && isset($_POST["lat"]) && isset($_POST["lng"]) && isset($_POST["remark"]) && is_numeric($_POST["ward_id"]) && is_numeric($_POST["panchayat_id"]) && is_numeric($_POST["block_id"]) && is_numeric($_POST["district_id"]) && is_numeric($_POST["luminary_qr"]) && $_POST["ward_id"]>0 && $_POST["panchayat_id"]>0 && $_POST["block_id"]>0 && $_POST["district_id"]>0 && $_POST["luminary_qr"]>9999 )
			{
				if(strlen(trim($_POST["luminary_qr"]))>10)
				{
					$sql = "SELECT id, branch_value FROM login where uname='{$_POST["uname"]}' and  email='{$_POST["SID"]}'";
					$result = $conn->query($sql);
					if ($result->num_rows > 0)
					{
						$row = $result->fetch_assoc();
						$sql = "SELECT id FROM _f_device where dev_id='".trim($_POST["luminary_qr"])."'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							echo '{"status":"ERR", "detail":"IMEI already in use, please contact admin"}';
						} else {
							$sql = "INSERT INTO _f_device (dev_id,name,parent,ward,panchayat,block,district,project,luminary_qr,battery_qr,panel_qr,file,lat,lng,remark,updated_by) VALUES('".trim($_POST["luminary_qr"])."','".trim($_POST["pole_id"])."','".trim($_POST["ward_id"])."','".trim($_POST["ward_id"])."','".trim($_POST["panchayat_id"])."','".trim($_POST["block_id"])."','".trim($_POST["district_id"])."','".trim($row["branch_value"])."','".trim($_POST["luminary_qr"])."','".trim($_POST["battery_qr"])."','".trim($_POST["panel_qr"])."','".trim($_POST["file"])."','".trim($_POST["lat"])."','".trim($_POST["lng"])."','".trim($_POST["remark"])."','".trim($_POST["uname"])."')";
						}
						if ($conn->query($sql) === TRUE){
							$delQuery = "DELETE FROM _i_inventory WHERE device_imei = '".trim($_POST["luminary_qr"])."'";
							$delResult = $conn->query($delQuery);
							$latestDataQuery = "INSERT INTO _g_data_latest (device) VALUES('".trim($_POST["luminary_qr"])."')";
							$conn->query($latestDataQuery);	
							echo '{"status":"OK", "detail":"Device Added Successfully !!!"}';
						} else {
							echo '{"status":"ERR", "detail":"DB Error"}';
						}
					} else {
						echo '{"status":"ERR", "detail":"Login Again"}';
					}
				} else {
					echo '{"status":"ERR", "detail":"Invalid IMEI Length"}';
				}
			} else {
				echo '{"status":"ERR", "detail":"Invalid Parameter"}';
			}
		break;
		
		case "Logout":
			if( isset($_POST["uname"]) && isset($_POST["SID"]) )
			{
				$sql = "SELECT id FROM login where uname='".$_POST["uname"]."' and  email='".$_POST["SID"]."'";
				$result = $conn->query($sql);
				if ($result->num_rows > 0)
				{
					$sql = "UPDATE login SET email='' WHERE uname='".$_POST["uname"]."'";
					if ($conn->query($sql) === TRUE){
						echo '{"status":"OK", "detail":"Logout Successful !!!"}';
					} else {
						echo '{"status":"ERR", "detail":"DB Error"}';
					}
				} else {
					echo '{"status":"ERR", "detail":"Login Again"}';
				}
			} else {
				echo '{"status":"ERR", "detail":"Invalid Parameter"}';
			}
			
		break;
	
		default:
		echo '{"status":"ERR", "detail":"Invalid Parameter"}';
		break;
	}
}
?>
