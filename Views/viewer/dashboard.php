<style>
.tableFixHead thead th {
	position: sticky;
	top: 0;
}

th {
	background: #107090!important;
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
  
  -webkit-transform:rotate(323deg);
  -moz-transform:rotate(323deg);
  -ms-transform:rotate(323deg);
  -o-transform:rotate(323deg);
  transform:rotate(323deg);
  padding: 11px 13px 0px 5px;
  color: red;
}

.w3-animate-zoom-x {
	animation:animatezoom 2s infinite linear
}

@keyframes animatezoom{
	from{
		transform:scale(0)
	} 

	to{
		transform:scale(1)
	}
}
</style>
  <!-- Header -->
  <header class="w3-container w3-text-indigo" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Dashboard</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16 m8-fancy w3-black">
        <div class="w3-left"><i class="w3-icon fa fa-lightbulb-o w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
						<?php
						$all = 0;
						$faulty = 0;
						$healthy = 0;
						$device_arr = array();
						$userDevices = "";
						$tree = array("_g_data", "_f_device", "_e_ward", "_d_panchayat", "_c_block", "_b_district", "_a_project");
						if ($branch > 6) $branch = 6;
						if ($branch < 2) $branch = 2;
						$entry = strtolower(explode("_", $tree[$branch])[2]);

						$sql = "SELECT dev_id FROM _f_device where " . $entry . "='" . $branch_value . "' and active=1";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								$device_arr[] = $row["dev_id"];
							}
							$userDevices = implode("','", $device_arr);
							$userDevices = "'".$userDevices."'";

							$latestDataQuery = "SELECT * FROM _h_fault_data WHERE device IN (".$userDevices.") AND (panel_fault = 1 OR luminary_fault = 1 OR battery_fault = 1)";
							$resultData = $conn->query($latestDataQuery);
							if($resultData->num_rows > 0){
								$faulty = $resultData->num_rows;
							}
							echo $all = $result->num_rows;
							$healthy = $all - $faulty;
						} else {
							echo $all = 0;
							$healthy = $faulty = $all;
						}
						?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Total Lights</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16 m8-fancy w3-black">
        <div class="w3-left"><i class="w3-icon fa fa-lightbulb-o w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $healthy; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Healthy Lights</h4>
      </div>
    </div>
    <div class="w3-quarter" onclick="window.location.assign('?item=7')">
      <div class="w3-container w3-red w3-padding-16 w3-hover-amber m8-fancy w3-black">
        <div class="w3-left"><i class="w3-icon fa fa-lightbulb-o w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo $faulty; ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Faulty Lights</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-padding-16 m8-fancy w3-black">
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
    <div class="w3-quarter w3-button0" onclick0="window.location.assign('?item=2')">
      <div class="w3-container w3-indigo w3-padding-16 w3-hover-red0 m8-fancy w3-black">
        <div class="w3-left"><i class="w3-icon fa fa-user w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
						<?php
						$distIdsArr = array();
						if ($branch == 6) {
							$sql = "SELECT id FROM _b_district where parent='" . $branch_value . "'";
							$result = $conn->query($sql);
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()){
									$distIds[] = $row["id"];
								}
								echo count($distIds);
							} else {
								echo "0";
							}
						} else if ($branch == 5){
							echo "1";
						} else {
							echo "0";
						}
						?>
					</h3>
        </div>
        <div class="w3-clear"></div>
        <h4 class="w3-left">Total Districts</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-purple w3-padding-16 m8-fancy w3-black">
        <div class="w3-left"><i class="w3-icon fa fa-user-o w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
					<?php
						$blockArr = array();
						$distStr = implode("','", $distIds);
						$distStr = "'".$distStr."'";
						if ($branch == 6){
							$sql = "SELECT id FROM _c_block WHERE parent IN (".$distStr.")";
						} else if ($branch == 5){
							$sql = "SELECT id FROM _c_block WHERE parent='" . $branch_value . "'";
						} else if ($branch == 4){
							$sql = "SELECT 1 as id";
						} else {
							$sql = "SELECT 0 as id";
						}
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()){
								$blockArr[] = $row["id"];
							}
							echo count($blockArr);
						}
						?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Blocks</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-green w3-padding-16 m8-fancy w3-black">
        <div class="w3-left"><i class="w3-icon fa fa-user-secret w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
						<?php
						$panchArr = array();
						$blockStr = implode("','", $blockArr);
						$blockStr = "'".$blockStr."'";
						if ($branch == 6) {
							$sql = "SELECT id FROM _d_panchayat where parent IN (".$blockStr.")";
						} else if ($branch == 5) {
							$sql = "SELECT  id FROM _d_panchayat where parent IN (".$blockStr.")";
						} else if ($branch == 4) {
							$sql = "SELECT  id FROM _d_panchayat where parent='" . $branch_value . "'";
						} else if ($branch == 3) {
							$sql = "SELECT 1 as id";
						} else {
							$sql = "SELECT 0 as id;";
						}
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()){
								$panchArr[] = $row["id"];
							}
							echo count($panchArr);
						}
						?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Panchayat</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-deep-orange w3-padding-16 m8-fancy w3-black">
        <div class="w3-left"><i class="w3-icon fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>
						<?php
						$panchStr = implode("','", $panchArr);
						$panchStr = "'".$panchStr."'";
						if ($branch == 6) {
							$sql = "SELECT count(id) as id FROM _e_ward where parent IN (".$panchStr.")";
						} else if ($branch == 5) {
							$sql = "SELECT count(id) as id FROM _e_ward where parent IN (".$panchStr.")";
						} else if ($branch == 4) {
							$sql = "SELECT count(id) as id FROM _e_ward where parent IN (".$panchStr.")";
						} else if ($branch == 3) {
							$sql = "SELECT count(id) as id FROM _e_ward where parent='" . $branch_value . "'";
						} else if ($branch == 2) {
							$sql = "SELECT 1 as id";
						} else{
							$sql = "SELECT 0 as id;";
						}
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
	<div class="w3-card w3-white w3-padding w3-row w3-center m8-fancy w3-black">
	  <div class="w3-third w3-mobile"><img src="../img/co2.jpg" style="height:100px"></div>
	  <div class="w3-third w3-mobile">
		<b>
		CO2 Emmision Reduction
		<h1><?php echo $co2 = round($pwr/10.55,5); ?> m<sup>3</sup></h1>
		</b>
	  </div>
	  <div class="w3-third w3-mobile">
		<b>
		Equivalent trees absorbed CO<sub>2</sub> annually
		<h1><?php echo round($co2/(48*0.00045359290943564),1); ?> Tree <i class="fa fa-tree w3-text-green w3-animate-zoom-x"></i></h1>
		</b>
	  </div>
	</div>
  </div>

  <div class="w3-container w3-section">
	<div style="width: 100%" class="w3-card m8-fancy"><div class="w3-card m8-fancy" id="googleMap" style="width:100%;height:400px;"></div></div>
  </div>
  
  <div class="w3-row">
  
	<div class="w3-container w3-section w3-half">
	  <div class="w3-card m8-fancy" id="graph" style="height:500px;"></div>
	</div>

	<div class="w3-container w3-section w3-half">
	  <div class="w3-card m8-fancy" id="pie" style="width:100%; max-width:600px; height:500px;"></div>
	</div>
  
  </div>

<div class="w3-container w3-responsive tableFixHead w3-small m8-fancy">
	<table id="id01" class="w3-table-all m8-fancy" style="overflow-y:scroll; overflow-x:scroll; height:400px;">
	  <thead>
	  <tr class="w3-color">
		<th>Date & Time</th>
		<th>IMEI</th>
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
		<td><a href="https://www.google.com/maps/search/?api=1&query=0,0" target="_blank" class="w3-large"><i class="fa fa-globe w3-text-color"></i></a></a></td>
	  </tr>
	  </tbody>
	</table>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATX7SRJg6UuAUdl6gCM8fy26lBorZ5h2I&callback=myMap"></script>

<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
//chart
var data = google.visualization.arrayToDataTable([
  <?php 
  $sql = "SELECT distinct name FROM _b_district where 1 limit 10";
  $result = $conn->query($sql);
  if ($result->num_rows > 0)
  {
	echo "['District', 'District'],";
	while($row = $result->fetch_assoc())
	{
	echo "['".$row["name"]."',1],";
	}
  }
  ?>
]);

var options = {
  title:'Device List Ratio in District'
};

var chart = new google.visualization.BarChart(document.getElementById('graph'));
  chart.draw(data, options);
  
//pie
var data = google.visualization.arrayToDataTable([
  <?php 
  $sql = "SELECT distinct name FROM _b_district where 1 limit 10";
  $result = $conn->query($sql);
  if ($result->num_rows > 0)
  {
	echo "['District', 'District'],";
	while($row = $result->fetch_assoc())
	{
	echo "['".$row["name"]."',1],";
	}
  }
  ?>
]);

var options = {
  title:'Device List Ratio in District',
  is3D:true
};

var chart = new google.visualization.PieChart(document.getElementById('pie'));
  chart.draw(data, options);
}


//table
w3.getHttpObject("../Controller/getAllLog.php", myFunction);
w3.getHttpObject("../Controller/getMapsLog.php", myFunction2);
w3.id("id01").style.height= (document.documentElement.clientHeight - 300) + "px";

function myFunction(myObject)
{
	w3.displayObject("id01", myObject);
}

function myFunction2(myObject)
{
	LoadMap(myObject.result);
}

function LoadMap(myObject) {
	var i=0;
	for(i=0; i<myObject.length; i++)
	if(myObject[i].lat>0 && myObject[i].lng>0)
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
			icon:'../img/green.png'
		});

		//Attach click event to the marker.
		(function (marker, data) {
			google.maps.event.addListener(marker, "click", function (e) {
				infoWindow.setContent("<div style = 'width:250px;min-height:40px'><b style='font-weight: 500!important;'>POLE ID: " + data.name + "<br>IMEI: </b>" + data.IMEI + "</div>");
				infoWindow.open(map, marker);
			});
		})(marker, data);
	}
}
</script>
