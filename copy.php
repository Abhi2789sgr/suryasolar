<?php 
//session_start();
require './Controller/connection.php';

$sql = "SELECT dev_id, COUNT(dev_id) as cnt FROM _f_device GROUP BY dev_id HAVING COUNT(dev_id) > 1;";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
	while($row = $result->fetch_assoc())
	{
		echo $row["dev_id"]." , ".$row["cnt"]."<br>";
	}
}
else
echo "EMPTY";
?>