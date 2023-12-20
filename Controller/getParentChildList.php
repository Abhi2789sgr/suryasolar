<?php
require './connection.php';
$table_name = $_GET['branch'];
$parent = $_GET['parent'];

$query = "SELECT * FROM ".$table_name;
if($parent != ''){
    $query .= " WHERE parent = ".$parent;
}

$result = $conn->query($query);
$responseData = array();
while($row = $result->fetch_assoc()){
    $responseData[] = $row;
}

echo json_encode($responseData);
?>