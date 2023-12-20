<style>
	.tableFixHead thead th {
		position: sticky;
		top: 0;
	}

	th {
		background: #107090 !important;
	}

	.strikethrough {
		position: relative;
	}

	.strikethrough:before {
		position: absolute;
		content: "";
		left: 0;
		top: 29%;
		right: 0;
		border-top: 1px solid;
		border-color: inherit;

		-webkit-transform: rotate(323deg);
		-moz-transform: rotate(323deg);
		-ms-transform: rotate(323deg);
		-o-transform: rotate(323deg);
		transform: rotate(323deg);
		padding: 11px 13px 0px 5px;
		color: red;
	}

	.w3-animate-zoom-x {
		animation: animatezoom 2s infinite linear
	}

	@keyframes animatezoom {
		from {
			transform: scale(0)
		}

		to {
			transform: scale(1)
		}
	}
</style>
<!-- Header -->
<header class="w3-container w3-text-indigo" style="padding-top:22px">
	<h5><b><i class="fa fa-dashboard"></i> Dashboard</b></h5>
</header>

<div class="w3-row-padding w3-margin-bottom">
	<div class="w3-quarter">
		<div class="w3-container w3-blue w3-black w3-padding-16 w3-round-large">
			<div class="w3-left"><i class="w3-icon fa fa-lightbulb-o w3-xxxlarge"></i></div>
			<div class="w3-right">
				<h3>
					<?php
					$all = 0;
					$faulty = 0;
					$healthy = 0;
					$offline = 0;
					$device_arr = array();
					$sql = "SELECT dev_id FROM _f_device where active=1";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$device_arr[] = $row["dev_id"];
						}

						$userDevices = implode("','", $device_arr);
						$userDevices = "'".$userDevices."'";

						$latestDataQuery = "SELECT * FROM _h_fault_data WHERE device IN (".$userDevices.") AND (panel_fault = 1 OR luminary_fault = 1 OR battery_fault = 1)";
						$resultData = $conn->query($latestDataQuery);
						$faulty = $resultData->num_rows;
						echo $all = $result->num_rows;
						$healthy = $all - $faulty;
					} else {
						echo $all = 0;
						$healthy = $faulty = $all;
					}
					?>
				</h3>
			</div>
			<div class="w3-clear"></div>
			<h4>Total Lights</h4>
		</div>
	</div>
	<div class="w3-quarter">
		<div class="w3-container w3-black w3-padding-16 w3-round-large">
			<div class="w3-left"><i class=" w3-icon fa fa-lightbulb-o w3-xxxlarge"></i></div>
			<div class="w3-right">
				<h3><?php echo $healthy; ?></h3>
			</div>
			<div class="w3-clear"></div>
			<h4>Healthy Lights</h4>
		</div>
	</div>
	<div class="w3-quarter " onclick="window.location.assign('?item=7')">
		<div class="w3-container w3-black w3-padding-16 w3-hover-amber m8-fancy" onclick="window.location.assign('?item=7')" style="height: 114px;">
			<div class="w3-left"><i class="w3-icon fa fa-lightbulb-o w3-xxxlarge"></i></div>
			<div class="w3-right">
				<h5><?php echo $faulty; ?></h5>
			</div>
			<!-- <div class="w3-clear"></div> -->
			<h5>Faulty</h5>
			<?php

			$twentyHoursAgo = date('Y-m-d H:i:s', strtotime('-2 days'));
			// echo $twentyHoursAgo;

			$query = "SELECT device FROM _g_data_latest WHERE time <= '{$twentyHoursAgo}'";
			$result = $conn->query($query);
			$offlineDevices = $result->num_rows;
			// echo $result;
			
			?>

			<h5 style="margin-top: 24px;">Offline</h5>
			<div class="w3-right" style="margin-right: -10px; margin-top:-35px">
				<h5><?php echo $offlineDevices; ?></h5>
			</div>
		</div>
	</div>
	<div class="w3-quarter">
		<div class="w3-container w3-black w3-padding-16 w3-round-large">
			<div class="w3-left"><i class="w3-icon fa fa-plug w3-xxxlarge"></i></div>
			<div class="w3-right">
				<h5>
					<?php
					$pwr = "0";
					$sql = "SELECT id FROM _g_data ORDER BY id DESC LIMIT 1";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo $pwr = $row["id"] / 1000;
					}
					?> kWh</h5>
			</div>
			<div class="w3-clear"></div>
			<h4>Energy Saving</h4>
		</div>
	</div>
</div>

<div class="w3-row-padding w3-margin-bottom">
	<div class="w3-quarter" onclick="window.location.assign('?item=2')">
		<div class="w3-container w3-blue w3-black w3-padding-16 w3-round-large ">
			<div class="w3-left"><i class="w3-icon fa fa-user w3-xxxlarge"></i></div>
			<div class="w3-right">
				<h3>
					<?php
					$sql = "SELECT count(id) as id FROM _b_district";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo $row["id"];
					}
					?>
				</h3>
			</div>
			<div class="w3-clear"></div>
			<h4 class="w3-left">Total Districts</h4>
		</div>
	</div>
	<div class="w3-quarter">
		<div class="w3-container w3-black w3-padding-16 w3-round-large">
			<div class="w3-left"><i class="w3-icon fa fa-user-o w3-xxxlarge"></i></div>
			<div class="w3-right">
				<h3>
					<?php
					$sql = "SELECT count(id) as id FROM _c_block";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo $row["id"];
					}
					?></h3>
			</div>
			<div class="w3-clear"></div>
			<h4>Blocks</h4>
		</div>
	</div>
	<div class="w3-quarter">
		<div class="w3-container w3-blue w3-black w3-padding-16 w3-round-large">
			<div class="w3-left"><i class="w3-icon fa fa-user-secret w3-xxxlarge"></i></div>
			<div class="w3-right">
				<h3>
					<?php
					$sql = "SELECT count(id) as id FROM _d_panchayat";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo $row["id"];
					}
					?></h3>
			</div>
			<div class="w3-clear"></div>
			<h4>Panchayat</h4>
		</div>
	</div>
	<div class="w3-quarter">
		<div class="w3-container w3-black w3-padding-16 w3-round-large">
			<div class="w3-left"><i class=" w3-icon fa fa-users w3-xxxlarge"></i></div>
			<div class="w3-right">
				<h3>
					<?php
					$sql = "SELECT count(id) as id FROM _e_ward";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						echo $row["id"];
					}
					?></h3>
			</div>
			<div class="w3-clear"></div>
			<h4>Ward</h4>
		</div>
	</div>
</div>
<div class="w3-section w3-container">
	<div class="w3-card w3-black w3-padding w3-row w3-center w3-round-large">
		<div class="w3-third w3-mobile"><img src="../img/co2.jpg" style="height:100px"></div>
		<div class="w3-third w3-mobile">
			<b>
				CO2 Emmision Reduction
				<h1><?php echo $co2 = round($pwr / 10.55, 5); ?> m<sup>3</sup></h1>
			</b>
		</div>
		<div class="w3-third w3-mobile">
			<b>
				Equivalent trees absorbed CO<sub>2</sub> annually
				<h1><?php echo round($co2 / (48 * 0.00045359290943564), 1); ?> Tree <i class="fa fa-tree w3-text-green w3-animate-zoom-x"></i></h1>
			</b>
		</div>
	</div>
</div>

<div class="w3-container w3-section">
	<div style="width: 100%" class="w3-card m8-fancy">
		<div class="w3-card m8-fancy" id="googleMap" style="width:100%;height:400px;"></div>
	</div>
</div>

<div class="w3-row">

	<div class="w3-container w3-section w3-third">
		<div class="w3-card m8-fancy" id="graph" style="height:500px;"></div>
	</div>

	<div class="w3-container w3-section w3-third">
		<div class="w3-card m8-fancy" id="pie" style="width:100%; max-width:600px; height:500px;"></div>
	</div>

	<div class="w3-container w3-section w3-third">
		<div class="w3-card m8-fancy" id="ring" style="width:100%; max-width:600px; height:500px;"></div>
	</div>

</div>

<!-- get on/off logs -->
<div class="w3-section w3-container">

	<div class="w3-container w3-text-indigo" style="padding-top:22px">
		<h5><b><i class="fa fa-history"></i> Get On/Off Logs</b></h5>
	</div>
	<div class="w3-card w3-white w3-padding w3-row w3-center m8-fancy">
		<form class="form-inline" id="data_form">
			<select class="custom-select my-1 mr-sm-2 mx-1 my-1" style="width:150px;border-radius: 0; " id="project" name="project" onchange="project_changed(event)">
				<option value="Project">Project</option>
				<option w3-repeat="output" value={{ID}}>{{Name}}</option>
			</select>
			<select class="custom-select my-1 mr-sm-2 mx-1 my-1" style="width:150px;border-radius: 0; " id="district" name="district" onchange="district_changed(event)">
				<option value='District'>District</option>
				<option w3-repeat="output" value={{ID}}>{{Name}}</option>
			</select>
			<select class="custom-select my-1 mr-sm-2 mx-1 my-1" style="width:150px;border-radius: 0; " id="block" name="block" onchange="block_changed(event)">
				<option value='Block'>Block</option>
				<option w3-repeat="output" value={{ID}}>{{Name}}</option>
			</select>
			<select class="custom-select my-1 mr-sm-2 mx-1 my-1" style="width:150px;border-radius: 0; " id="panchayat" name="panchayat" onchange="panchayat_changed(event)">
				<option value='Panchayat'>Panchayat</option>
				<option w3-repeat="output" value={{ID}}>{{Name}}</option>
			</select>
			<select class="custom-select my-1 mr-sm-2 mx-1 my-1" style="width:150px;border-radius: 0; " id="ward" name="ward" onchange="ward_changed(event)">
				<option value='Ward'>Ward</option>
				<option w3-repeat="output" value={{ID}}>{{Name}}</option>
			</select>
			<input class="w3-left w3-margin m8-fancy w3-button w3-border" style="width:150px;border-radius: 0;" type="text" onfocus="(this.type='date')" id="startDate" placeholder="Start Date" oninput="enableBtn()">

			<input class="w3-left w3-margin m8-fancy w3-button w3-border" type="text" onfocus="(this.type='date')" style="width:150px;border-radius: 0;" id="endDate" placeholder="End Date" oninput="enableBtn()">

			<button class="w3-button w3-red w3-right w3-margin m8-fancy" id="csvBtn" disabled>Download CSV</button>
			<button class="w3-button w3-red w3-right w3-margin m8-fancy" id="pdfBtn" disabled>Download PDF</button>
		</form>
	</div>
</div>

<div class="w3-margin m8-fancy">
	<input type="text" oninput="inventorySearch(this.value)" placeholder="Type imei here..." style="width:40%;">
	<i class="fa fa-search" style="font-size:20px"></i>
</div>

<div class="w3-container w3-responsive tableFixHead w3-small m8-fancy">
	<table id="id01" class="w3-table-all m8-fancy" style="overflow-y:scroll; overflow-x:scroll; height:400px;">
		<thead>
			<tr class="w3-color">
				<th>Date & Time</th>
				<th>IMEI</th>
				<th>Pole-ID</th>
				<th>Battery Percentage</th>
				<th>Battery Voltage</th>
				<th>Battery Current</th>
				<th>Battery Power</th>
				<th>Solar Voltage</th>
				<th>Solar Current</th>
				<th>Solar Power</th>
				<th>SSL Voltage</th>
				<th>SSL Current</th>
				<th>SSL Power</th>
				<th>Full Brightness hour</th>
				<th>Half Brightness hour</th>
				<th>Total Glowing Hour </th>
				<th>WH of Day </th>
				<th>Cumulative kWH </th>
				<th>Battery Status</th>
				<th>Light Status</th>
				<th>Dusk/ Down</th>
				<th>Luminary Fault</th>
				<th>Battery Fault</th>
				<th>Panel Fault</th>
				<th>System Fault</th>
				<th>Locate</th>
			</tr>
		</thead>
		<tbody>
			<tr w3-repeat="result">
				<td>{{Time}}</td>
				<td>{{IMEI}}</td>
				<td>{{Pole-ID}}</td>
				<td>{{V1}} %</td>
				<td>{{V2}}</td>
				<td>{{V3}}</td>
				<td>{{V4}}</td>
				<td>{{V5}}</td>
				<td>{{V6}}</td>
				<td>{{V7}}</td>
				<td>{{V8}}</td>
				<td>{{V9}}</td>
				<td>{{V10}}</td>

				<td>{{V14}}</td>
				<td>{{V15}}</td>
				<td>{{V16}}</td>
				<td>{{V17}}</td>
				<td>{{V18}}</td>
				<td>{{V11[5]}}</td>
				<td><i class="fa {{V11[7]}} w3-large"></i></td>
				<!---<td><i class="fa {{V11[5]}} w3-large"></i></td>--->
				<!---<td><span class="{{V11[7]}}"><i class="fa fa-lightbulb-o w3-large"></i></span></td>--->
				<td><i class="fa {{V11[6]}} w3-large"></i></td>
				<td><i class="fa fa-circle w3-text-{{V11[4]}} w3-large"></i></td>
				<td><i class="fa fa-circle w3-text-{{V11[3]}} w3-large"></i></td>
				<td><i class="fa fa-circle w3-text-{{V11[2]}} w3-large"></i></td>
				<td><i class="fa fa-circle w3-text-{{V11[2,3,4]}} w3-large"></i></td>
				<td><a href="https://www.google.com/maps/search/?api=1&query={{latlng}}" target="_blank" class="w3-large"><i class="fa fa-globe w3-text-color"></i></a></a></td>
			</tr>
		</tbody>
	</table>
</div>
<br>
<center><button onclick="goToPreviousLogs()" style="cursor:pointer;"><b><u>Previous</u></b></button>
	<button onclick="goToNextLogs()" style="cursor:pointer;"><b><u>Next</u></b></button>
</center>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATX7SRJg6UuAUdl6gCM8fy26lBorZ5h2I&callback=myMap"></script>
<!-- pdfMake Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<!-- pdfMake Script -->
<script>
	var logPageNo = 0;
	var maxpages = 0;
	var limit = 50;
	google.charts.load('current', {
		'packages': ['corechart']
	});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		//chart
		var data = google.visualization.arrayToDataTable([
			<?php
			$sql = "SELECT _a_project.name, COUNT(_f_device.id) as id_count FROM _a_project JOIN _f_device ON _a_project.id = _f_device.project GROUP BY _a_project.id limit 20";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				echo "['Projects', 'Projects'],";
				while ($row = $result->fetch_assoc()) {
					echo "['" . $row["name"] . "'," . $row["id_count"] . "],";
				}
			}
			?>
		]);

		var options = {
			title: 'Device List Ratio in Projects',
			colors: ['#e05220', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6']
		};

		var chart = new google.visualization.BarChart(document.getElementById('graph'));
		chart.draw(data, options);

		//pie
		/*var data = google.visualization.arrayToDataTable([
		  <?php
			// $sql = "SELECT _a_project.name, COUNT(_f_device.id) as id_count FROM _a_project JOIN _f_device ON _a_project.id = _f_device.project GROUP BY _a_project.id limit 20";
			// $result = $conn->query($sql);
			// if ($result->num_rows > 0)
			// {
			// echo "['Projects', 'Projects'],";
			// while($row = $result->fetch_assoc())
			// {
			// echo "['".$row["name"]."',".$row["id_count"]."],";
			// }
			// }
			// 
			?>
		]); */

		var options = {
			title: 'Device List Ratio in Projects',
			colors: ['#FF1493', '#7B68EE', '#FF0000', '#FFD700', '#FF8C00', '#32CD32', '#4682B4', '#556B2F', '#0000FF', '#A52A2A', '#BC8F8F', '#F08080', '#9400D3', '#C71585', '#FFA07A', '#BDB76B', '#3CB371', '#87CEFA', '#BC8F8F', '#483D8B'],
			is3D: true
		};

		var chart = new google.visualization.PieChart(document.getElementById('pie'));
		chart.draw(data, options);


		//ring
		var data = google.visualization.arrayToDataTable([
			<?php
			echo "['Projects', 'Projects'],";
			echo "['Healthy Lights'," . $all - $faulty . "],";
			echo "['Faulty Lights'," . $faulty . "],";
			?>
		]);

		var options = {
			title: 'Devices Health Ratio',
			colors: ['#009933', '#ff3300'],
			pieHole: 0.4
		};

		var chart = new google.visualization.PieChart(document.getElementById('ring'));
		chart.draw(data, options);
	}

	//table
	w3.getHttpObject("../Controller/getAllLog.php", myFunction);
	w3.getHttpObject("../Controller/getMapsLog.php", myFunction2);
	w3.id("id01").style.height = (document.documentElement.clientHeight - 300) + "px";

	function goToNextLogs() {
		if (logPageNo < maxpages) {
			logPageNo = logPageNo + 1;
			w3.getHttpObject("../Controller/getAllLog.php?pageNo=" + logPageNo + "&limit=" + limit, myFunction);
		}
	}

	function goToPreviousLogs() {
		if (logPageNo > 0) {
			logPageNo = logPageNo - 1;
			w3.getHttpObject("../Controller/getAllLog.php?pageNo=" + logPageNo + "&limit=" + limit, myFunction);
		}
	}

	function myFunction(myObject) {
		if (logPageNo == 0) {
			maxpages = Math.floor((myObject.result[0]).id / limit);
		}
		w3.displayObject("id01", myObject);
	}

	function myFunction2(myObject) {
		LoadMap(myObject.result);
	}

	function LoadMap(myObject) {
		var i = 0;
		for (i = 0; i < myObject.length; i++)
			if (myObject[i].lat > 0 && myObject[i].lng > 0)
				break;

		var mapOptions = {
			center: new google.maps.LatLng(myObject[i].lat, myObject[i].lng),
			zoom: 5,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);

		//Create and open InfoWindow.
		var infoWindow = new google.maps.InfoWindow();

		for (var i = 0; i < myObject.length; i++) {
			var data = myObject[i];
			var myLatlng = new google.maps.LatLng(data.lat, data.lng);
			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: data.name,
				icon: '../img/green.png'
			});

			//Attach click event to the marker.
			(function(marker, data) {
				google.maps.event.addListener(marker, "click", function(e) {
					infoWindow.setContent("<div style = 'width:250px;min-height:40px'><b style='font-weight: 500!important;'>POLE ID: " + data.name + "<br>IMEI: </b>" + data.IMEI + "</div>");
					infoWindow.open(map, marker);
				});
			})(marker, data);
		}
	}
	var timerId;

	function inventorySearch(search = '') {
		let xhr = new XMLHttpRequest();
		clearTimeout(timerId);
		timerId = setTimeout(function() {
			// xhr.open("GET", "../Controller/getAllLog?search="+search);
			w3.getHttpObject("../Controller/getAllLog.php?search=" + search, myFunction);
		}, 2000);

	}
	inventorySearch();

	//  On/Off log Script

	let project = document.getElementById("project");
	let district = document.getElementById("district");
	let block = document.getElementById("block");
	let panchayat = document.getElementById("panchayat");
	let ward = document.getElementById("ward");

	function loadList(category, parent_id) {
		//console.log("loadList called" + category + " " + parent_id);
		//////console.log(category);
		w3.getHttpObject(`../Controller/getDeviceHierarchy.php?category=${category}&parent_id=${parent_id}`, myFunction3);

		function myFunction3(myObject) {
			//category is id of the container to be populated
			//console.log(myObject.output[0]);
			w3.displayObject(category, myObject);
		}
	}
	loadList("project", 1);

	function project_changed(event) {
		let id = event.target.value;
		let id_text = event.target.selectedOptions[0].text;
		//console.log(id + " " + id_text);
		if (id != "Project" && id > 0) {
			loadList("district", id);
			enableBtn();
		}
		$("#block").html("<option value=''>Block</option><option w3-repeat='output' value={{ID}}>{{Name}}</option>");
		$("#panchayat").html("<option value=''>Panchayat</option><option w3-repeat='output' value={{ID}}>{{Name}}</option>");
		$("#ward").html("<option value=''>Ward</option><option w3-repeat='output' value={{ID}}>{{Name}}</option>");
	}

	function district_changed(event) {
		let id = event.target.value;
		let id_text = event.target.selectedOptions[0].text;
		//console.log(id + " " + id_text);
		if (id != "District" && id > 0) {
			loadList("block", id);
		}
		$("#panchayat").html("<option value=''>Panchayat</option><option w3-repeat='output' value={{ID}}>{{Name}}</option>");
		$("#ward").html("<option value=''>Ward</option><option w3-repeat='output' value={{ID}}>{{Name}}</option>");
	}

	function block_changed(event) {
		let id = event.target.value;
		let id_text = event.target.selectedOptions[0].text;
		//console.log(id + " " + id_text);
		if (id != "Block" && id > 0) {
			loadList("panchayat", id);
		}
		$("#ward").html("<option value=''>Ward</option><option w3-repeat='output' value={{ID}}>{{Name}}</option>");
	}

	function panchayat_changed(event) {
		let id = event.target.value;
		let id_text = event.target.selectedOptions[0].text;
		//console.log(id + " " + id_text);
		if (id != "Panchayat" && id > 0) {
			loadList("ward", id);
		}
	}

	function ward_changed(event) {
		let id = event.target.value;
		let id_text = event.target.selectedOptions[0].text;
		//console.log(id + " " + id_text);
	}

	function enableBtn() {
		if (project.value != "" && (startDate.value && endDate.value) && (startDate.value <= endDate.value)) {
			//console.log(project.value);
			csvBtn.removeAttribute("disabled");
			pdfBtn.removeAttribute("disabled");
		} else {
			disableBtn();
		}
	}

	function disableBtn() {
		csvBtn.setAttribute("disabled", true);
		pdfBtn.setAttribute("disabled", true);
	}
	disableBtn();

	// download csv
	document.getElementById("csvBtn").addEventListener("click", function(event) {
		event.preventDefault();
		//console.log("CSV download is clicked")
		pro_id = document.getElementById('project').value;
		dist_id = document.getElementById('district').value == "District" ? "" : document.getElementById('district').value;
		block_id = document.getElementById('block').value == "Block" ? "" : document.getElementById('block').value;
		panch_id = document.getElementById('panchayat').value == "Panchayat" ? "" : document.getElementById('panchayat').value;
		ward_id = document.getElementById('ward').value == "Ward" ? "" : document.getElementById('ward').value;

		//console.log(pro_id + " " + dist_id + " " + block_id + " " + panch_id + " " + ward_id + " " + startDate.value + " " + endDate.value);

		let url = '?project_id=' + pro_id + '&district_id=' + dist_id + '&block_id=' + block_id + '&panchayat_id=' + panch_id + '&ward_id=' + ward_id;
		//console.log(url);
		w3.getHttpObject("../Controller/admin/downloadOnOffLogs.php" + url + "&startDate=" + startDate.value + "&endDate=" + endDate.value + "&imei=0", myFunction);

		function myFunction(myObject) {
			let csv = 'IMEI,PoleID,OnTime,OffTime,OnDuration\n';
			myObject.result.forEach(function(row) {
				csv += row.dev_imei + ','
				csv += row.PoleID + ',';
				csv += row.OnTime + ',';
				csv += row.OffTime + ',';
				csv += row.OnDuration + "\n";
			});

			var hiddenElement = document.createElement('a');
			hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
			hiddenElement.target = '_blank';
			hiddenElement.download = "OnOffLog" + '.csv';
			hiddenElement.click();
		}
	});

	// download pdf
	document.getElementById("pdfBtn").addEventListener("click", function(event) {
		event.preventDefault();

		pro_id = document.getElementById('project').value;
		dist_id = document.getElementById('district').value == "District" ? "" : document.getElementById('district').value;
		block_id = document.getElementById('block').value == "Block" ? "" : document.getElementById('block').value;
		panch_id = document.getElementById('panchayat').value == "Panchayat" ? "" : document.getElementById('panchayat').value;
		ward_id = document.getElementById('ward').value == "Ward" ? "" : document.getElementById('ward').value;

		//console.log(pro_id + " " + dist_id + " " + block_id + " " + panch_id + " " + ward_id + " " + startDate.value + " " + endDate.value);

		let url = '?project_id=' + pro_id + '&district_id=' + dist_id + '&block_id=' + block_id + '&panchayat_id=' + panch_id + '&ward_id=' + ward_id;
		//console.log(url);
		w3.getHttpObject("../Controller/admin/downloadOnOffLogs.php" + url + "&startDate=" + startDate.value + "&endDate=" + endDate.value + "&imei=0", myFunction);

		let pro = document.getElementById('project').selectedOptions[0].text;
		let dist = document.getElementById('district').selectedOptions[0].text;
		let block = document.getElementById('block').selectedOptions[0].text;
		let panch = document.getElementById('panchayat').selectedOptions[0].text;
		let ward = document.getElementById('ward').selectedOptions[0].text;
		// //console.log(pro)
		function myFunction(myObject) {
			//console.log(myObject.result);
			let str = pro;
			if (dist != 'District') str += " -> " + dist;
			if (block != 'Block') str += " -> " + block;
			if (panch != 'Panchayat') str += " -> " + panch;
			if (ward != 'Ward') str += " -> " + ward;
			let myArr = [
				['IMEI', 'Pole ID', 'On Time', 'Off Time', 'On Duration'],
			];

			myObject.result.forEach((row) => {
				myArr.push([row.dev_imei, row.PoleID, row.OnTime, row.OffTime, row.OnDuration]);
			})

			//console.log(myArr);

			var docDefinition = {
				content: [{
					text: 'Device Log\n' + str + "\n\n\n",
					fontStyle: 15,
					lineHeight: 1
				}, {
					layout: 'lightHorizontalLines', // optional
					table: {
						headerRows: 1,
						widths: ['auto', 'auto', 'auto', 'auto', 'auto'],
						body: myArr
					}
				}]
			};
			pdfMake.tableLayouts = {
				exampleLayout: {
					hLineWidth: function(i, node) {
						if (i === 0 || i === node.table.body.length) {
							return 0;
						}
						return (i === node.table.headerRows) ? 2 : 1;
					},
					vLineWidth: function(i) {
						return 0;
					},
					hLineColor: function(i) {
						return i === 1 ? 'black' : '#aaa';
					},
					paddingLeft: function(i) {
						return i === 0 ? 0 : 8;
					},
					paddingRight: function(i, node) {
						return (i === node.table.widths.length - 1) ? 0 : 8;
					}
				}
			};
			pdfMake.createPdf(docDefinition).download('On/OffLogs');
		}
	});
</script>
