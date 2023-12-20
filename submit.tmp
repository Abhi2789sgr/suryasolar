<?php 
$str=",1003,04,060,06";

if (!isset($_GET["q"])){
  die('err_1');//data count invalid
}
$q = $_GET["q"];
if ($q==""){
  die('err_1');//data count invalid
} 

$q = explode(",",$q);

if(count($q)!=21){
  die("NACK".$str);//die('err_1');//data count invalid
}

$id = $q[0];//imei

require './Controller/connection.php';

$bypass = 1;

// $sql = "SELECT id FROM _f_device WHERE dev_id='".$id."' AND active='1'";//device disabled
// $result = $conn->query($sql);
// if($result->num_rows > 0 || $bypass)
if($bypass)
{
  $sql = "INSERT INTO `_g_data` (`device`, `v1`, `v2`, `v3`, `v4`, `v5`, `v6`, `v7`, `v8`, `v9`, `v10`, `v11`, `v12`, `v13`, `v14`, `v15`, `v16`, `v17`, `v18`, `v19`, `v20`) VALUES ('".$id."', '".$q[1]."', '".$q[2]."', '".$q[3]."', '".$q[4]."', '".$q[5]."', '".$q[6]."', '".$q[7]."', '".$q[8]."', '".$q[9]."', '".$q[10]."', '".$q[11]."', '".$q[12]."', '".$q[13]."', '".$q[14]."', '".$q[15]."', '".$q[16]."', '".$q[17]."', '".$q[18]."', '".$q[19]."', '".$q[20]."')";
  if ($conn->query($sql) === TRUE){
    $sqlLatest = "UPDATE _g_data_latest SET `v1`='".$q[1]."', `v2`='".$q[2]."', `v3`='".$q[3]."', `v4`='".$q[4]."', `v5`='".$q[5]."', `v6`='".$q[6]."', `v7`='".$q[7]."', `v8`='".$q[8]."', `v9`='".$q[9]."', `v10`='".$q[10]."', `v11`='".$q[11]."', `v12`='".$q[12]."', `v13`='".$q[13]."', `v14`='".$q[14]."', `v15`='".$q[15]."', `v16`='".$q[16]."', `v17`='".$q[17]."', `v18`='".$q[18]."', `v19`='".$q[19]."', `v20`='".$q[20]."' WHERE `device`='".$id."'";
    $conn->query($sqlLatest);
    $date = date('Y-m-d H:i:s');
    $faultData = $q[11];
    $panelFault = $faultData[2];
    $batteryFault = $faultData[3];
    $luminaryFault = $faultData[4];
    $faultQuery = "SELECT * FROM _h_fault_data WHERE device ='".$id."'";
    $faultResult = $conn->query($faultQuery);
    if($faultResult->num_rows > 0){
      $row = $faultResult->fetch_assoc();
      if($panelFault != $row['panel_fault'] || $batteryFault != $row['battery_fault'] || $luminaryFault != $row['luminary_fault']){
        $updateQuery = "UPDATE _h_fault_data SET ";
        $panelFlag = false;
        if($panelFault != $row['panel_fault']){
          $panelFlag = true;
          if($panelFault == "1"){
            $updateQuery .= "panel_fault = 1, panel_fault_reported = '".$date."',panel_fault_resolved = NULL";
          }else{
            $updateQuery .= "panel_fault = 0, panel_fault_resolved = '".$date."'";
          }
        }

        $batteryFlag = false;
        if($batteryFault != $row['battery_fault']){
          $batteryFlag = true;
          if($panelFlag){
            $updateQuery .= ", ";
          }

          if($batteryFault == "1"){
            $updateQuery .= "battery_fault = 1, battery_fault_reported = '".$date."',battery_fault_resolved = NULL";
          }else{
            $updateQuery .= "battery_fault = 0, battery_fault_resolved = '".$date."'";
          }
        }

        if($luminaryFault != $row['luminary_fault']){
          if($panelFlag || $batteryFlag){
            $updateQuery .= ", ";
          }

          if($luminaryFault == "1"){
            $updateQuery .= "luminary_fault = 1, luminary_fault_reported = '".$date."',luminary_fault_resolved = NULL";
          }else{
            $updateQuery .= "luminary_fault = 0, luminary_fault_resolved = '".$date."'";
          }
        }
        $updateQuery .= "WHERE device = '".$id."'";
        $conn->query($updateQuery);
      }
    }else{
      if($panelFault != "0" || $batteryFault != "0" || $luminaryFault != "0"){

        $panel_fault_reported = $panelFault != "0" ? "'".$date."'" : "NULL";
        $luminary_fault_reported = $luminaryFault != "0" ? "'".$date."'" : "NULL";
        $battery_fault_reported = $batteryFault != "0" ? "'".$date."'" : "NULL"; 

        $insertQuery = "INSERT INTO _h_fault_data (`device`, `panel_fault`, `panel_fault_reported`, `panel_fault_resolved`, `luminary_fault`, `luminary_fault_reported`, `luminary_fault_resolved`, `battery_fault`, `battery_fault_reported`, `battery_fault_resolved`) VALUES ('".$id."', ".intval($panelFault).", ".$panel_fault_reported.", NULL, ".intval($luminaryFault).", ".$luminary_fault_reported.", NULL, ".intval($batteryFault).", ".$battery_fault_reported.", NULL)";
        $conn->query($insertQuery);

      }
    }
    $changeByte = $q[12];
    if($changeByte[7] == '1'){
      $lightStatusQuery = "INSERT INTO `_j_light_status` (`device`, `status`) VALUES ('".$id."', ".intval($faultData[7]).")";
      $conn->query($lightStatusQuery);
    }
    echo "PACK".$str;//echo "ok";
  } else {
    echo "NACK".$str;
  }
  //echo "err_2";//can't access database server
} else {
  die("NACK".$str);//die('err_3');//invalid IMEI or device disabled
}
$conn->close();
?>
