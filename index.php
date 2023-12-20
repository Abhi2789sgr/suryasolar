<?php
if(str_contains($_SERVER['HTTP_HOST'], 'www')){
	header('Location: https://solarrmsorient.co.in');
   }else{
	   header("Location: ./Views/index.php");
   }
   exit;
?>
