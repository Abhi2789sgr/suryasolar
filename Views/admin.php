<?php
if(str_contains($_SERVER['HTTP_HOST'],'www')){
        header('Location: https://solarrmsorient.co.in');
}
session_start();
require '../Controller/connection.php';
if( isSession("uid") && isSession("pass") )
{
$uid  = session("uid");
$pass = session("pass");
}
else
header("Location: index.php");

$sql = "SELECT name, branch, branch_value FROM login where uname='{$uid}' and pass='{$pass}' and type='1' and active=1";
$result = $conn->query($sql);
if ($result->num_rows > 0)
{
$row          = $result->fetch_assoc();
$name         = $row["name"];
$branch       = $row["branch"];
$branch_value = $row["branch_value"];
?>
<!DOCTYPE html>
<html>
<title>Dashboard | <?php echo $project_name; ?></title>
<meta charset="UTF-8">
<meta name="author" content="Manav Akela">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/w4.css">
<script src="../js/w3.js"></script>
<script src="../js/script.js?version=1.003"></script>
 <!-- jQuery -->
 <script type="text/javascript" src="../js/jquery.js"></script>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!---favicon start--->
<link rel="apple-touch-icon-precomposed" href="../img/favicon.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../img/favicon.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../img/favicon.png" />
<link rel="shortcut icon" href="../img/favicon.png">
<!---favicon stop--->

<style>
html,body,h1,h2,h3,h4,h5,h6,h7 {font-family: "Raleway", sans-serif}
.w3-color, .w3-hover-color:hover{color: #fff!important;background-color: #ED1C24!important;}
.w3-text-color, .w3-hover-text-color:hover {color: #ED1C24!important;}
</style>
<body class="w3-light-grey">


<!-- Top container -->

<div class="w3-bar w3-top w3-large w3-card-4" style="z-index:4;background-color:#fff;color:#fff;">
  <button class="w3-bar-item w3-button w3-hide-large w3-text-color w3-hover-none" style="margin-top:9px;" onclick="w3.toggleHide('#mySidebar,#myOverlay');"><i class="fa fa-bars"></i></button>
  <img src="../img/logo.png" class="w3-bar-item w3-hide-small">
  <span class="w3-bar-item w3-hide-small" style="background-color:#ED1C24;height:61px;padding-top:15px;"><b><?php echo $project_name; ?></b></span>
  <span class="w3-bar-item w3-hide-medium w3-hide-large" style="background-color:#ED1C24;height:61px;padding-top:15px;"><b>SuryaRMS</b></span>
  <a href="../Controller/logout.php" class="w3-right w3-text-color w3-light-gray w3-button w3-hide-small" style="padding:17px;" title="Logout"><i class="fa fa-sign-out fa-fw"></i></a>
  <span class="w3-hide-small w3-right w3-large w3-margin-left w3-margin-right" style="margin-top:17px;color:#ED1C24;"><span>Welcome, <strong><?php echo $name; ?></strong></span></span>
  <span class="w3-bar-item0 w3-right w3-hide-small"><img src="../img/user2.png" style="height:61px;"></span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-animate-opacity w3-color w3-text-white" style="z-index:3;width:200px;" id="mySidebar"><br>

  <div class="w3-container">
    <h5>Menu</h5>
  </div>
  <div class="w3-bar-block">
    <a href="?item=1" class="w3-bar-item w3-button w3-padding w3-round-large" id="item_1"><i class="fa fa-dashboard fa-fw"></i>&nbsp; Dashboard</a>
    <a href="?item=2" onclick="javascript:localStorage.back_enable=0;" class="w3-bar-item w3-button w3-padding w3-round-large" id="item_2"><i class="fa fa-table fa-fw"></i>&nbsp; Record</a>
    <a href="?item=3" class="w3-bar-item w3-button w3-padding w3-round-large" id="item_3"><i class="fa fa-users fa-fw"></i>&nbsp; Manage User</a>
    <a href="?item=4" class="w3-bar-item w3-button w3-padding w3-round-large" id="item_4"><i class="fa fa-microchip fa-fw"></i>&nbsp; Manage Device</a>
    <a href="?item=8" class="w3-bar-item w3-button w3-padding w3-round-large" id="item_8"><i class="fa fa-database fa-fw"></i>&nbsp; Inventory</a>
    <a href="?item=9" class="w3-bar-item w3-button w3-padding w3-round-large" id="item_9"><i class="fa fa-file-text-o fa-fw"></i>&nbsp; Reports</a>
    <a href="?item=5" class="w3-bar-item w3-button w3-padding w3-round-large" id="item_5"><i class="fa fa-cog fa-fw"></i>&nbsp; Settings</a>
	<hr class="w3-hide-medium w3-hide-large"></hr>
    <a href="../Controller/logout.php" class="w3-bar-item w3-button w3-padding w3-round-large w3-hide-medium w3-hide-large" id=""><i class="fa fa-sign-out fa-fw"></i>&nbsp; Logout</a><br><br>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3.hide('#mySidebar,#myOverlay');" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<?php require "./hiddenElements.php"; ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:200px;margin-top:43px;">

  <?php 
  $item = get("item");
  if($item=="1")
  require "./admin/dashboard.php";
  else if($item=="2")
  require "./admin/history.php";
  else if($item=="3")
  require "./admin/manageUser.php";
  else if($item=="4")
  require "./admin/manageDevice.php";
  else if($item=="5")
  require "./admin/settings.php";
  else if($item=="6")
  require "./admin/log.php";
  else if($item=="7")
  require "./admin/faultyList.php";
  else if($item=='8')
  require "./admin/inventory.php";
  else if($item=='9')
  require "./admin/reports.php";
  else if($item=="10")
  require "./admin/onOffLog.php";
  else 
  require "./admin/dashboard.php";
  ?>

  <footer class="w3-container w3-padding-16 w3-light-grey">
    <p class="w3-left"><?php echo $project_name; ?> @ 2022</p>
    <p class="w3-right w3-margin-right">Powered by <a href="https://surya.co.in" target="_blank">Surya Roshni</a></p>
  </footer>
</div>

<script>
<?php 
if(isGet("item")) 
echo 'w3.addClass("#item_'.get("item").'", "w3-blue");';
if(get("item")=="6")
echo "onStart();";
?>
</script>
<!-- Bootstrap script -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

<?php 
}
else
{
session_unset();
session_destroy();
header("Location: ./index.php?err");
}
?>
