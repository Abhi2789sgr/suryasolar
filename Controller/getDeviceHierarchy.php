<?php
require './connection.php';
$sql = "";
$out = "";
if ($_GET['category'] == "project") {
    $sql = "SELECT id,name FROM _a_project WHERE parent = " . $_GET['parent_id'];
    loadData($sql);
}

if ($_GET['category'] == "district") {
    $sql = "SELECT id,name FROM _b_district WHERE parent = " . $_GET['parent_id'];
    loadData($sql);
}

if ($_GET['category'] == "block") {
    $sql = "SELECT id,name FROM _c_block WHERE parent = " . $_GET['parent_id'];
    loadData($sql);
}

if ($_GET['category'] == "panchayat") {
    $sql = "SELECT id,name FROM _d_panchayat WHERE parent = " . $_GET['parent_id'];
    loadData($sql);
}

if ($_GET['category'] == "ward") {
    $sql = "SELECT id,name FROM _e_ward WHERE parent = " . $_GET['parent_id'];
    loadData($sql);
}

function loadData($sql_query)
{
    global $conn, $out;
    $result = $conn->query($sql_query);
    $out = "";
    while ($row = $result->fetch_assoc()) {
        if ($out != "") {
            $out .= ",";
        }

        $out .= '{"ID":"' . $row["id"] . '",';
        $out .= '"Name":"' . $row["name"] . '"}';
    }
    $out = '{"output":[' . $out . ']}';
    echo ($out);
}
