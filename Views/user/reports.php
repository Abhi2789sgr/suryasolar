<header class="w3-container w3-text-indigo" style="padding-top:22px">
	<h5><b><i class="fa fa-microchip"></i> Manage Device</b></h5>
</header>
<div class="w3-container w3-margin-bottom">
	<button style="margin:5px" class="w3-right w3-button w3-color m8-fancy w3-margin-top" onclick="w3.show('#downloadInstalledDevice')">Installation Report</button>
</div>

<div class="w3-container w3-margin-bottom" >
		<div class="w3-animate-top w3-section w3-border w3-round-xlarge w3-white w3-text-color"style="display: none;"id="downloadInstalledDevice">
			<div class="w3-row" id="id02">
				<div class="w3-button w3-circle w3-red w3-right w3-margin" onclick="w3.hide('#downloadInstalledDevice')">X</div>
				<h3 style="padding-left:12px;">Download Installation Report</h3>
				<hr>
				<div class="w3-col s12 m6 l3" id="showDistList" onclick="w3.show('#showBlockList')">
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
						<select class="w3-input w3-border w3-round" id="wardId" onchange="setWardId(this.value)">
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

<script>
var project_id = <?php echo $branch_value; ?>;
fillItems('_b_district', project_id);
var district_id = "";
var block_id = "";
var panchayat_id = "";
var ward_id = "";
function fillItems(table_name, id) {
	sw();
	w3.getHttpObject("../Controller/getParentChildList.php?branch=" + table_name + "&parent=" + id, function(result) {
		if (table_name == '_b_district') {
			var district_list = {
				'district_list': result
			};
			w3.displayObject("showDistList", district_list);
			w3.id('blockId').value = -1;
			w3.id('panchId').value = -1;
			w3.id('wardId').value = -1;
			project_id = id;
			district_id = "";
			block_id = "";
			panchayat_id = "";
			ward_id = "";
		}
		if (table_name == '_c_block') {
			var block_list = {
				'block_list': result
			};
			w3.displayObject("showBlockList", block_list);
			w3.id('panchId').value = -1;
			w3.id('wardId').value = -1;
			district_id = id;
			block_id = "";
			panchayat_id = "";
			ward_id = "";
		}
		if (table_name == '_d_panchayat') {
			var panchayat_list = {
				'panchayat_list': result
			};
			w3.displayObject("showPanchList", panchayat_list);
			w3.id('wardId').value = -1;
			block_id = id;
			panchayat_id = "";
			ward_id = "";
		}
		if (table_name == '_e_ward') {
			var ward_list = {
				'ward_list': result
			};
			w3.displayObject("showWardList", ward_list);
			panchayat_id = id;
			ward_id = "";
		}
		sw();
		// console.log(projectId);
	});
}

function setWardId(id){
	ward_id = id;
}
function downloadList() {
	if(project_id != "" && project_id != '-1'){
		var params = "";
		if(project_id != ""){
			params = params+'?project='+project_id;
		}
		if(district_id != "" && district_id != '-1'){
			params = params+'&district='+district_id;
		}
		if(block_id != "" && block_id != '-1'){
			params = params+'&block='+block_id;
		}
		if(panchayat_id != "" && panchayat_id != '-1'){
			params = params+'&panchayat='+panchayat_id;
		}
		if(ward_id != "" && ward_id != '-1'){
			params = params+'&ward='+ward_id;
		}
		var url = '../../Controller/devicesExport.php'+params;
		window.location.href = url;
	}else{
		alert("Atleast select any proect");
	}
}
</script>