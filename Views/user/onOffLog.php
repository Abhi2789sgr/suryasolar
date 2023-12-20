<style>
	.tableFixHead thead th {
		position: sticky;
		top: 0;
	}

	table.style {
		overflow: scroll;
	}

	th {
		background: #e05220 !important;
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
</style>

<!-- Header -->
<header class="w3-container w3-text-indigo" style="padding-top:22px">
	<h5><b onclick="history.back();" style="cursor:pointer;"><i class="fa fa-history"></i>
			<lable id="log_title">Log</lable>
		</b><b> > <lable id="log_name"></lable></b></h5>
</header>

<div class="w3-container">
	<div class="w3-card w3-white w3-margin-bottom w3-row m8-fancy">
		<div class="w3-row w3-color w3-center w3-padding m8-fancy">
			<b>Device Details</b>
		</div>
		<div class="w3-container w3-padding">
			<div class="w3-col s6 m3 l3">
				<div><b>S.No. / Device Name</b></div>
			</div>
			<div class="w3-col s6 m3 l3">
				<div id="log_name2"></div>
			</div>
			<div class="w3-col s6 m3 l3">
				<div><b>Device IMEI</b></div>
			</div>
			<div class="w3-col s6 m3 l3">
				<div id="log_imei"></div>
			</div>
		</div>
	</div>
</div>

<!-- download -->
<div class="w3-container w3-margin-bottom w3-row">

	<input class="w3-left w3-margin m8-fancy w3-button w3-border" type="text" onfocus="(this.type='date')" id="startDate" placeholder="Start Date" oninput="enableBtn()">

	<input class="w3-left w3-margin m8-fancy w3-button w3-border" type="text" onfocus="(this.type='date')" id="endDate" placeholder="End Date" oninput="enableBtn()">

	<button class="w3-button w3-red w3-right w3-margin m8-fancy" id="csvBtn" onclick="downloadCSV()">Download CSV</button>

	<button class="w3-button w3-red w3-right w3-margin m8-fancy" id="pdfBtn" onclick="downloadPDF()">Download PDF</button>
</div>

<!-- table -->
<div class="w3-container w3-responsive tableFixHead">
	<table id="id02" class="w3-table-all " style="overflow-x:scroll;overflow-y:scroll;">
		<thead>
			<tr class="w3-color">
				<th>On Time</th>
				<th>Off Time</th>
				<th>On Duration</th>
			</tr>
		</thead>
		<tbody>
			<tr w3-repeat="result">
				<td>{{OnTime}}</td>
				<td>{{OffTime}} </td>
				<td>{{OnDuration}}</td>
			</tr>
		</tbody>
	</table>
	<center>
		<button onclick="getPrevLogs()" style="cursor:pointer;"><b><u>Previous</u></b></button>
		<button onclick="getNextLogs()" style="cursor:pointer;"><b><u>Next</u></b></button>
	</center>
</div>
<!-- pdfmake  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<!-- pdfmake  -->
<script>
	var limit = 10;
	var pageNo = 0;
	var totalPage = 0;

	function onStart() {
		if (localStorage.temp_name != undefined && localStorage.temp_imei != undefined) {
			sw();
			var name = localStorage.temp_name;
			var imei = localStorage.temp_imei;
			w3.id("log_name").innerHTML = name;
			w3.id("log_name2").innerHTML = name;
			w3.id("log_imei").innerHTML = imei;
			w3.getHttpObject("../Controller/user/getOnOffLog.php?imei=" + imei + '&limit=50&pageNo=' + pageNo, myFunction);
		}
		localStorage.back_enable = "1";
	}
	onStart();

	function getNextLogs() {
		if (pageNo < maxpages) {
			pageNo = pageNo + 1;
			onStart();
		}
	}

	function getPrevLogs() {
		if (pageNo > 0) {
			pageNo = pageNo - 1;
			onStart();
		}
	}

	function myFunction(myObject) {
		w3.displayObject("id02", myObject);
		maxpages = Math.floor((myObject.result[0]).id / limit);
		w3.id("log_title").innerHTML = "ON/OFF Log";
		sw();
	}

	// download
	let startDate = document.getElementById("startDate");
	let endDate = document.getElementById("endDate");
	let csvBtn = document.getElementById("csvBtn");
	let pdfBtn = document.getElementById("pdfBtn");

	function disableBtn() {
		csvBtn.setAttribute("disabled", true);
		pdfBtn.setAttribute("disabled", true);
	}
	disableBtn();

	function downloadCSV() {
		if (localStorage.temp_name != undefined && localStorage.temp_imei != undefined) {
			var name = localStorage.temp_name;
			var imei = localStorage.temp_imei;
			w3.getHttpObject("../Controller/user/downloadOnOffLogs.php?imei=" + imei + "&startDate=" + startDate.value + "&endDate=" + endDate.value, myFunction);
		}

		function myFunction(myObject) {
			let csv = 'OnTime,OffTime,OnDuration\n';
			myObject.result.forEach(function(row) {
				csv += row.OnTime + ',';
				csv += row.OffTime + ',';
				csv += row.OnDuration + "\n";
			});

			var hiddenElement = document.createElement('a');
			hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
			hiddenElement.target = '_blank';
			hiddenElement.download = imei + '.csv';
			hiddenElement.click();
		}


	}


	function downloadPDF() {
		//console.log(startDate.value + "  " + endDate.value);
		var imei, name;

		if (localStorage.temp_name != undefined && localStorage.temp_imei != undefined) {
			name = localStorage.temp_name;
			imei = localStorage.temp_imei;
			w3.getHttpObject("../Controller/user/downloadOnOffLogs.php?imei=" + imei + "&startDate=" + startDate.value + "&endDate=" + endDate.value, myFunction);
		}

		function myFunction(myObject) {
			//console.log(myObject.result);
			const document = {
				content: [{
					text: 'Device Log\nimei: ' + imei + '\nDevice Name: ' + name + '\n\n\n',
					fontStyle: 15,
					lineHeight: 1
				}]
			}
			document.content.push({
					columns: [{
							text: 'On Time',
							width: 160,
							color:'blue'
						},
						{
							text: 'Off Time',
							width: 160,
							color:'blue'
						},
						{
							text: 'On Duration',
							width: 80,
							color:'blue'
						}
					],
					lineHeight: 2,
				});
			myObject.result.forEach(row => {
				document.content.push({
					columns: [{
							text: row.OnTime,
							width: 160
						},
						{
							text: row.OffTime,
							width: 160
						},
						{
							text: row.OnDuration,
							width: 80
						}
					],
					lineHeight: 1
				});
			});
			pdfMake.createPdf(document).download(imei);
		}
	}


	function enableBtn() {

		if ((startDate.value && endDate.value) && (startDate.value <= endDate.value)) {
			csvBtn.removeAttribute("disabled");
			pdfBtn.removeAttribute("disabled");
		} else {
			disableBtn();
		}
	}
</script>