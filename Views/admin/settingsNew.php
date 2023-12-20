<?php
include '../../Controller/connection.php';
$sql = "select id, name from _a_project";
$result = $conn->query($sql);
?>
<!-- Header -->
<header class="w3-container w3-text-indigo" style="padding-top:22px">
	<h5><b><i class="fa fa-cog"></i> Settings</b></h5>
</header>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<div class="dropdown w3-containe w3-text-color w3-padding w3-margin " style="margin-left: 26px;">
	<label for="projects"><b>Choose a Project: </b></label>
	<select name="name" id="dwopdownProject" class="dropdown" style="width:200px; height:30px" onchange="selectProject()">
		<option value="">Choose project</option>
		<!-- <option value="">Default project</option> -->
		<?php
		while ($row = mysqli_fetch_array($result)) :;
			$ids = $row['id'];
			$names = $row['name'];
		?>
			<option value="<?php echo $ids; ?>"> <?php echo $names; ?> </option>
			<!-- <option value="niceLab">NiceLab</option>
			<option value="xyz-breda">XYZ-BREDA</option> -->
		<?php endwhile ?>
	</select>
</div>

<div class="w3-row w3-container">
	<div class="w3-half w3-padding w3-row">
		<div class="w3-container w3-white w3-card w3-round-large w3-text-color">
			<h4><b>Change update rate</b></h4>
			<label class="w3-text-color"><b>Update Rate (In Minutes)</b></label>
			<input class="w3-input w3-border w3-light-grey" type="text" id="upRate" name="upRate" min="1" max="999">
			<input id="project_input" name="project_id" type="hidden">
			<button class="w3-button w3-color w3-border w3-border-color w3-round-large w3-section form-control" id="updateRate" type="button" onclick="updateRateTable()">Save</button>
		</div>
	</div>
	<div class="w3-half w3-padding w3-row">
		<div class="w3-container w3-white w3-card w3-round-large w3-text-color ">
			<h4><b>Update Firmware</b></h4>
			<label class="w3-text-color"><b>Firmware Version</b></label>
			<input class="w3-input w3-border w3-light-grey" name="firmwareVersion" type="number" id="firmwareVersion" min="1" max="9999">
			<input id="project_input" name="project_id" type="hidden">
			<form action="../Controller/admin/upload.php" method="post" enctype="multipart/form-data" class="w3-section">
				<br>
				<label class="w3-text-color"><b>Select BIN file to upload</b></label>
				<input class="w3-input w3-border w3-light-grey" type="file" name="fileToUpload" id="fileToUpload">
				<!-- <input id="project_input" name="project_id" type="hidden"> -->
				<button class="w3-button w3-color w3-border w3-border-color w3-round-large w3-section form-control" id="updateRate" type="button" onclick="updateFirmware()">Upload Firmware</button>
				<!-- <input class="w3-button w3-color w3-border w3-border-color w3-round-large w3-section" type="submit" value="Upload Firmware" name="submit"> -->
			</form>
		</div>
	</div>
	<!---
  <div class="w3-half w3-padding">
	<div class="w3-container w3-white w3-card w3-round-large">
	  <h4>U2</h4>
	</div>
  </div>
  <div class="w3-half w3-padding">
	<div class="w3-container w3-red w3-card w3-round-large">
	  <h4>U3</h4>
	</div>
  </div>--->
</div>

<script>
	// function submitForm(dform) {
	// 	var urate = w3.id("urate").value;
	// 	var versn = w3.id("versn").value;

	// 	if (urate > 999 || urate < 1 || urate.length != 3) {
	// 		alert("Update rate should be in range of 001 to 999");
	// 		return 1;
	// 	}

	// 	if (versn > 9999 || versn < 1 || versn.length != 4) {
	// 		alert("Firmware version should be in range of 0001 to 9999");
	// 		return 1;
	// 	}

	// 	var http = new XMLHttpRequest();
	// 	http.onload = formSubmitted;
	// 	http.open("post", dform.action);
	// 	http.send(new FormData(dform));
	// }

	// function formSubmitted() {
	// 	if (this.status == 200) {
	// 		var res = this.response.split("$$");
	// 		if (res[1] == "1")
	// 			urate();
	// 		else
	// 			alert(res[0]);
	// 	}
	// }

	function selectProject() {
		// alert("hello world");
		var projectId = document.getElementById("dwopdownProject").value;
		// console.log(x);
		$.ajax({
			url: "admin/fetchData.php",
			method: "POST",
			data: {
				projectId: projectId
			},
			dataType: "JSON",
			success: function(data) {
				document.getElementById("project_input").value = projectId;
				document.getElementById("upRate").value = data.updaterate;
				document.getElementById("firmwareVersion").value = data.firmwareVersion;
				document.getElementById("fileToUpload").value = data.binfile;
			}
		})
	}

	function updateRateTable() {
		// alert("hello");
		var projectId = document.getElementById("dwopdownProject").value;
		var upRate = document.getElementById("upRate").value;
		$.ajax({
			url: "../Controller/admin/getRate.php",
			method: "POST",
			data: {
				project_id: projectId,
				upRate: upRate,
				type: 'rate'
			},
			dataType: "JSON",
			success: function(data) {
				console.log(data);
			}
		})
	}


	function updateFirmware() {

		var projectId = document.getElementById("dwopdownProject").value;
		var firmwareVersion = document.getElementById("firmwareVersion").value;
		// var fileToUpload = document.getElementById("fileToUpload").value;
		$.ajax({
			url: "../Controller/admin/getRate.php",
			method: "POST",
			data: {
				project_id: projectId,
				firmwareVersion: firmwareVersion,
				// fileToUpload: fileToUpload,
				type: 'firmware'
			},
			dataType: "JSON",
			success: function(data) {
				console.log(data);
			}
		})
	}
	// function urate() {
	// 	var urate = w3.id("urate").value;
	// 	var versn = w3.id("versn").value;

	// 	if (urate > 999 || urate < 1 || urate.length != 8) {
	// 		alert("Update rate should be in range of 001 to 999");
	// 		return 1;
	// 	}

	// 	if (versn > 9999 || versn < 1 || versn.length != 10) {
	// 		alert("Firmware version should be in range of 0001 to 9999");
	// 		return 1;
	// 	}

	// 	var param = "urate=" + urate + "&versn=" + versn;

	// 	ajax("../Controller/admin/getRate.php", param);
	// }

	function ajax(url, params) {
		sw();
		if (window.XMLHttpRequest)
			xmlhttp = new XMLHttpRequest();
		else
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.open("POST", url, true);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4)
				if (xmlhttp.status == 200) {
					if (xmlhttp.responseText == "1")
						msg("Success!");
					else
						msg("Some error occurred. Please try again later");
					sw();
				}
			else
				sw();
		}
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.setRequestHeader("Content-length", params.length);
		xmlhttp.setRequestHeader("Connection", "close");
		xmlhttp.send(params);
	}
</script>
