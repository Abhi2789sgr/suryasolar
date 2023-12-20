<?php 
session_start();
require 'connection.php';
if( isSession("uid") && isSession("pass") )
{
  session_unset();
  session_destroy(); 
}
header("Location: ../index.php");
?>