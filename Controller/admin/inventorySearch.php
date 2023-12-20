<?php
session_start();
require '../../Controller/connection.php';
if (isSession("uid") && isSession("pass")) {
    $uid  = session("uid");
    $pass = session("pass");
} else
    header("Location: index.php");

$search = $_GET['search'];
$sql = "SELECT * FROM _i_inventory WHERE device_imei LIKE '%$search%' ";
$outp = "";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($outp != "") {
            $outp .= ",";
        }
        $outp .= '{"deviceImei":"' . $row["device_imei"] . '",';
        $outp .= '"created_at":"' . $row["created_at"] . '"}';
    }
    $outp = '{"result":[' . $outp . ']}';
    echo ($outp);
} else {
    $outp = '{"Device_Imei":"--","Created_at":"--"}';
    echo '{"result":[' . $outp . ']}';
}
?>
