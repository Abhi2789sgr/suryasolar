<?php
include '../../Controller/connection.php';

if($_POST['type'] == 'rate'){
$proj_id = $_POST['project_id'];
$upRate = $_POST['upRate'];


// $version = $_POST['firmwarev'];
//$fileToUpload = $_POST['binfile'];

//$query = "UPDATE _h_settings SET update_rate = '{$upRate}', firmware_version ='{$version}',	bin_file_path = '{$fileToUpload}' WHERE project_id= '{ $k}'";
$query = "UPDATE _h_settings SET update_rate = '{$upRate}'  WHERE project_id= '{$proj_id}'";

// $sql = "select * from _h_settings where project_id = '".$k."'";
$result = $conn->query($query);
// echo $result;
}elseif($_POST['type'] == 'firmware'){
    $proj_id = $_POST['project_id'];
    $firmwareVersion = $_POST['firmwareVersion'];
    // $fileToUpload = $_POST['fileToUpload'];

    $sql = "UPDATE _h_settings SET firmware_version ='{$firmwareVersion}' WHERE project_id= '{$proj_id}'";
    $result = $conn->query($sql);
    // echo $result;
}else{

}
?>
