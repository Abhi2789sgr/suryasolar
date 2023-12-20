<?php 
/*if(! empty($_SERVER['HTTP_USER_AGENT'])){
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if( preg_match('@(iPad|iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)@', $useragent) ){
        header('Location: ./mobile.php');
    }
}*/
$servername = "localhost";
$username = "rootuser";
$password = "SuryaRoot!@T12";
$dbname = "surya_solar";

if( $_SERVER['SERVER_ADDR'] == '127.0.0.1' && $_SERVER['REMOTE_ADDR'] == '127.0.0.1' )
{
$servername = "localhost";
$username = "manavakela1996";
$password = "0636";
$dbname = "solarrms";
}

$project_name = "Surya Street Light RMS";
$skey_top = "Reprico45087";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function isPost($data)
{
	if(isset($_POST[$data]))
	return true;
	else
	return false;
}

function isGet($data)
{
	if(isset($_GET[$data]))
	return true;
	else
	return false;
}

function isSession($data)
{
	if(isset($_SESSION[$data]))
	return true;
	else
	return false;
}

function get($data)
{
	if(isset($_GET[$data]))
	{
		$data = $_GET[$data];
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}

function post($data)
{
	if(isset($_POST[$data]))
	{
		$data = $_POST[$data];
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}
function session($data)
{
	if(isset($_SESSION[$data]))
	{
		$data = $_SESSION[$data];
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}

function hoursandmins($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return "--";
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}
?>
