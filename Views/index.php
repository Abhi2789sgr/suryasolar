<?php
if(str_contains($_SERVER['HTTP_HOST'],'www')){
	header('Location: https://solarrmsorient.co.in');
}
session_start();
require '../Controller/connection.php';
if( isSession("type") && isSession("uid") && isSession("pass") )
header("Location: ../Controller/login.php");
?>
<!DOCTYPE html>
<html>
<title>Login | <?php echo $project_name; ?></title>
<meta charset="UTF-8">
<meta name="author" content="Manav Akela">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../css/w4.css">
<script src="../js/script.js"></script>

<!---favicon start--->
<link rel="apple-touch-icon-precomposed" href="../img/favicon.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../img/favicon.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../img/favicon.png" />
<link rel="shortcut icon" href="../img/favicon.png">
<!---favicon stop--->

<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;}
body, html {
    height: 100%;
    color: #777;
    line-height: 1.8;
}
.bgimg-1 {
	background-color: #fff;
    background-attachment: fixed;
    background-position: top;
    background-repeat: no-repeat;
    background-size: cover;
    background-image: url('../img/login-bg.jpg');
    min-height: 100%;
}
@media all and (max-width: 2000px) and (min-width: 592px) {
  .margin-rt50 {
   margin-right:60px;
  }
}
</style>
<body class="bgimg-1" style="overflow-y: hidden;">

<div class="w3-bar w3-top w3-large w3-card-4" style="z-index:4;background-color:#fff;color:#fff;">
  <img src="../img/logo.png" class="w3-bar-item w3-hide-small">
  <span class="w3-bar-item w3-hide-small" style="background-color:#ED1C24;height:61px;padding-top:13px;"><b><?php echo $project_name; ?></b></span>
  <span class="w3-bar-item w3-hide-medium w3-hide-large" style="background-color:#ED1C24;height:61px;padding-top:13px;"><b>Surya RMS</b></span>
  <span class="w3-bar-item0 w3-right w3-hide-small w3-hide"><img src="../img/logo2.png" style="height:61px;"></span>
  <span class="w3-hide-small w3-right w3-xlarge w3-margin-right" style="margin-top:10px;color:#ED1C24;">मुख्यमंत्री ग्रामीण सोलर स्ट्रीट लाइट योजना</span>
</div>

<div class="w3-display-container" style="height:600px;margin-top:50px;">
    <div class="w3-display-right w3-padding">
		<div class="w3-panel w3-card-4 w3-round-large w3-center margin-rt50" style="background-color:#fff;color:#ED1C24;">
			<img src="../img/logo.png" alt="Avatar" style="min-width:100px;width:15%;" class="w3-margin-top">
			<form class="" action="../Controller/login.php" method="POST">
				<div class="w3-section">
					<label><b>Login Type</b></label>
					<select class="w3-select w3-input w3-border w3-margin-bottom w3-round-large" name="type" required autofocus>
					  <option value="" disabled selected>Choose Login Type</option>
					  <option value="1">Master</option>
					  <option value="2">Admin</option>
					  <option value="4">User</option>
					</select>
					<label><b>User ID</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="text" placeholder="Enter User ID" name="uid" required>
					<label><b>Password</b></label>
					<input class="w3-input w3-border w3-margin-bottom w3-round-large" type="password" placeholder="Enter Password" name="pass" required>
					<button class="w3-btn w3-border w3-round-large w3-margin-top w3-center w3-text-white" style="width:300px;background-color:#ED1C24;" type="submit">Login</button>
				</div>
			</form>
			<span class="w3-right w3-padding w3-hide">
				<a href="javascript:void(0)" class="w3-padding	" onclick="">Need Help?</a>
				<a href="javascript:void(0)" onclick="document.getElementById('login2').className='w3-hide';document.getElementById('forget').className='';document.getElementById('done').className='w3-hide';">Forgot password?</a>
			</span>
		</div>
	</div>
</div>

<?php require "./hiddenElements.php"; ?>

<script><?php if(isGet("err")) echo 'msg("Username or password missmatch");' ?></script>

</body>
</html>
