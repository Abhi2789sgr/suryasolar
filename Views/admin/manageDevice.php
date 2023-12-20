<!-- Header -->
<header class="w3-container w3-text-indigo" style="padding-top:22px">
	<h5><b><i class="fa fa-microchip"></i> Manage Device</b></h5>
</header>
<div class="w3-container w3-margin-bottom">
	<!-- <button class="w3-right w3-button w3-color m8-fancy w3-margin-top" onclick="w3.show('#addUser')">Add Device</button> -->
</div>
<div class="w3-container w3-margin-bottom" >
		<div class="w3-animate-top w3-section w3-border w3-round-xlarge w3-white w3-text-color"style="display: none;"id="downloadInstalledDevice">
			<div class="w3-row" id="id02">
				<div class="w3-button w3-circle w3-red w3-right w3-margin" onclick="w3.hide('#downloadInstalledDevice')">X</div>
				<h3 style="padding-left:12px;">Add Device</h3>
				<hr>
				<div class="w3-col s12 m6 l3" id="showProjList">
					<div style="padding: 10px;" onclick="w3.show('#showDistList')">
						<label>Project:</label>
						<select class="w3-input w3-border w3-round" id="projectID" onchange="fillItems('_b_district',this.value)">
							<option value="-1">Select Project</option>
							<option w3-repeat="project_list" value="{{id}}">{{name}}</option>
						</select>
					</div>
				</div>
				<div class="w3-col s12 m6 l3" id="showDistList" style="display: none;" onclick="w3.show('#showBlockList')">
					<div style="padding: 10px;">
						<label>District:</label>
						<select class="w3-input w3-border w3-round" id="districtId" onchange="fillItems('_c_block',this.value)">
							<option value="-1">Select District</option>
							<option w3-repeat="district_list" value="{{id}}">{{name}}</option>
						</select>
					</div>
				</div>
				<div class="w3-col s12 m6 l3" id="showBlockList" style="display: none;" onclick="w3.show('#showPanchList')">
					<div style="padding: 10px;">
						<label>Block :</label>
						<select class="w3-input w3-border w3-round" id="blockId" onchange="fillItems('_d_panchayat',this.value)">
							<option value="-1">Select Block</option>
							<option w3-repeat="block_list" value="{{id}}">{{name}}</option>
						</select>
					</div>
				</div>
				<div class="w3-col s12 m6 l3" id="showPanchList" style="display: none;" onclick="w3.show('#showWardList')">
					<div style="padding: 10px;">
						<label>Panchayat :</label>
						<select class="w3-input w3-border w3-round" id="panchId" onchange="fillItems('_e_ward',this.value)">
							<option value="-1">Select Panchayat</option>
							<option w3-repeat="panchayat_list" value="{{id}}">{{name}}</option>
						</select>
					</div>
				</div>
				<div class="w3-col s12 m6 l3" id="showWardList" style="display:none">
					<div style="padding: 10px;">
						<label>Ward :</label>
						<select class="w3-input w3-border w3-round" id="wardId">
							<option value="-1">Select Ward</option>
							<option w3-repeat="ward_list" value="{{id}}">{{name}}</option>
						</select>
					</div>
				</div>
			</div>
			<div class="w3-row" style="margin:10px">
				<button class="w3-col s12 m12 l12 w3-button w3-color w3-round" id="downloadBtn" onclick="downloadList()">Download Report</button>
		</div>
	</div>
</div>

<div class="w3-container w3-responsive">
	<table id="id01" class="w3-table-all">
		<tr class="w3-color">
			<th>Device Name</th>
			<th>IMEI</th>
			<th>Ward</th>
			<th>Panchayat</th>
			<th>Block</th>
			<th>District</th>
			<th>Luminary QR</th>
			<th>Battery QR</th>
			<th>Panel QR</th>
			<th>Updated By</th>
			<th>Image</th>
			<th>Locate</th>
			<th>Location Remark</th>
			<th>Date & Time</th>
			<th>Action</th>
		</tr>

		<?php
		$sql = "SELECT * FROM _f_device where active=0";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
		?>
				<tr>
					<td><?php echo $row["name"]; ?></td>
					<td><?php echo $row["dev_id"]; ?></td>
					<td><?php echo $row["ward"]; ?></td>
					<td><?php echo $row["panchayat"]; ?></td>
					<td><?php echo $row["block"]; ?></td>
					<td><?php echo $row["district"]; ?></td>
					<td><?php echo $row["luminary_qr"]; ?></td>
					<td><?php echo $row["battery_qr"]; ?></td>
					<td><?php echo $row["panel_qr"]; ?></td>
					<td><?php echo $row["updated_by"]; ?></td>
					<td><img src="data:image/png;base64,<?php echo $row["file"]; ?>" style="width:200px;"></td>
					<td><a href="https://www.google.com/maps/search/?api=1&query=<?php echo $row["lat"] . "," . $row["lng"]; ?>" target="_blank" class="w3-large"><i class="fa fa-globe w3-text-color"></i> Locate</a></a></td>
					<td><?php echo $row["remark"]; ?></td>
					<td><?php echo $row["time"]; ?></td>
					<td>
						<button class="w3-button w3-teal m8-fancy" style="width:100px;" onclick="authoriseDevice(<?php echo $row["dev_id"]; ?>)">Accept</button><br><br>
						<button class="w3-button w3-red m8-fancy" style="width:100px;">Delete</button><br><br>
						<button class="w3-button w3-color m8-fancy" style="width:100px;">Block IMEI</button>
					</td>
				</tr>
		<?php
			}
		} else
			echo "<tr><td>No new device found!</td></tr>";
		?>
	</table>
</div>


<script>
	function authoriseDevice(imei) {
		var param = "imei=" + imei;
		ajax("../Controller/admin/authoriseDevice.php", param, 1);
	}

	fillItems('_a_project', '');

function fillItems(table_name, id) {
	sw();
	console.log(id);
	w3.getHttpObject("../Controller/getParentChildList.php?branch=" + table_name + "&parent=" + id, function(result) {
		if (table_name == '_a_project') {
			var project_list = {
				'project_list': result
			};
			w3.displayObject("showProjList", project_list);
			w3.id('districtId').value = -1;
			w3.id('blockId').value = -1;
			w3.id('panchId').value = -1;
			w3.id('wardId').value = -1;
			
		}
		if (table_name == '_b_district') {
			var district_list = {
				'district_list': result
			};
			w3.displayObject("showDistList", district_list);
			w3.id('blockId').value = -1;
			w3.id('panchId').value = -1;
			w3.id('wardId').value = -1;
		}
		if (table_name == '_c_block') {
			var block_list = {
				'block_list': result
			};
			w3.displayObject("showBlockList", block_list);
			w3.id('panchId').value = -1;
			w3.id('wardId').value = -1;

		}
		if (table_name == '_d_panchayat') {
			var panchayat_list = {
				'panchayat_list': result
			};
			w3.displayObject("showPanchList", panchayat_list);
			w3.id('wardId').value = -1;
		}
		if (table_name == '_e_ward') {
			var ward_list = {
				'ward_list': result
			};
			w3.displayObject("showWardList", ward_list);
		}
		sw();
		// console.log(projectId);
	});
}

function downloadList() {
	var url = '../../orientsolar/Controller/devicesExport.php';
	window.location.href = url;
}

	function ajax(url, params, reload) {
		sw();
		if (window.XMLHttpRequest)
			xmlhttp = new XMLHttpRequest();
		else
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.open("POST", url, true);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4)
				if (xmlhttp.status == 200) {
					if (xmlhttp.responseText == "1") {
						msg("Success!");
						if (reload > 0)
							reload_on_close = 1;
					} else
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
