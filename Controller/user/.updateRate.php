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

$sql = "SELECT id FROM login where uname='{$uid}' and pass='{$pass}' and type='2' and active=1";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
	$row = $result->fetch_assoc();
	
	$urate   = "urate";
	$versn   = "versn";
	
	if( isPost($urate) && isPost($versn) )
	{
		$urate   = sprintf("%03u",post($urate));
		$urate_chk = "0";
		for($i=0;$i<3;$i++)
		  $urate_chk += $urate[$i];
		$urate_chk = sprintf("%02u",$urate_chk);
		
		$versn   = sprintf("%04u",post($versn));
		$versn_chk = "0";
		for($i=0;$i<4;$i++)
		  $versn_chk += $versn[$i];
		$versn_chk = sprintf("%02u",$versn_chk);
	
		/*$sql = "UPDATE login SET update_rate='".$urate."' WHERE uname='{$uid}'";
		if ($conn->query($sql) === TRUE)
			echo "1";
		else
			echo "2";*/
			
		$myfile  = fopen("../../submit.php", "r") or die("Unable to open submit.php file!");
		$myfile2 = fopen("../../submit.tmp", "w+") or die("Unable to open submit.tmp file!");
		$i = 0;
		while(!feof($myfile)) {
		  $i++;
		  $line = fgets($myfile);
		  if($i == 2)
		  $line = '$str=",'.$versn.','.$versn_chk.','.$urate.','.$urate_chk.'";
';
		  fputs($myfile2, $line);
		}
		fclose($myfile);
		fclose($myfile2);
		
		$myfile3 = fopen("getRate.php", "w+") or die("Unable to open file getRate.php!");
		fputs($myfile3, "1".$urate.$versn);
		fclose($myfile3);
		
		if(copy('../../submit.tmp', '../../submit.php'))
		echo "1";
		else
		echo "0";
	
	}
}
else
{
session_unset();
session_destroy();
header("Location: ../Views/index.php?err");
}
?>