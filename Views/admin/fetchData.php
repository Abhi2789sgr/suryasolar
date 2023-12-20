<?php
include '../../Controller/connection.php';


$k = $_POST["projectId"];

$sql = "select * from _h_settings where project_id = '".$k."'";
$result = $conn->query($sql);
while($rows = mysqli_fetch_array($result)){
    $data['id'] = $rows['project_id'];
    $data['updaterate'] = $rows['update_rate'];
    $data['firmwareVersion'] = $rows['firmware_version'];
    $data['binfile'] = $rows['bin_file_path'];
}

echo json_encode($data);

?>
