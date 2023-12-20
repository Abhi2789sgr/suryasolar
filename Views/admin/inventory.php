<!-- Header -->
<header class="w3-container w3-text-indigo" style="padding-top:22px">
    <h5><b><i class="fa fa-database"></i> Manage Inventory</b></h5>
</header>

<div class="w3-container w3-margin-bottom w3-row">
    <input class="w3-left w3-margin m8-fancy w3-button w3-border" type="text" id="myInput" oninput="inventorySearch(this.value)" placeholder="Search for IMEI..">
    <div class="w3-button w3-red w3-right w3-margin m8-fancy" id="deleteBtnTop" onclick="document.getElementById('id05').style.display='block'">Delete All</div>
    <div class="w3-button w3-color w3-right w3-margin m8-fancy" id="deleteBtnTop" onclick="document.getElementById('addInventoryModel').style.display='block'">Add Inventory</div>
</div>
<!-- <div class="w3-button w3-red w3-right w3-margin m8-fancy" onclick="document.getElementById('addInventoryModel').style.display='block'">Add Inventory</div> -->

<div class="w3-quarter" style="overflow-y: scroll;height:346px;overflow-x:hidden;margin-left:10px;" id="InvData">
    <div class="w3-bar w3-card w3-button m8-fancy" style="margin-bottom:10px; background-color:#f44336" w3-repeat="result">
        <div class="" style="text-align:left!important;" onclick="getLog('{{deviceImei}}')">
            <span class=" w3-large">{{deviceImei}}</span><br>
            <span><small><label class="created_date">Date-{{created_at}}</label></small></span>
        </div>
    </div>
</div>
<div class="" style="display:none; float: right; width:72%;" id="txtHint">
    <div class="w3-container">
        <div id="txtResult">
            <div class="w3-card w3-white w3-margin-bottom w3-row m8-fancy" style="border: 3px solid #f44336;height:346px;">
                <div class="w3-container w3-padding w3-small" id="id01">
                    <div class="w3-col s6 m3 l3 extraDetails" w3-repeat="result">
                        <div class="{{b}}" id="{{b}}">{{a}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w3-col s6 m3 l3" style="padding:5px;"><button class="w3-button w3-color m8-fancy" style="width:100%;" onclick="deleteSingleDevice()"><i class="fa fa-trash"></i> Delete</button></div>
</div>

<div id="addInventoryModel" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4" id="reShape" style="width:400px; height:275px">
        <header class="w3-container w3-color">
            <span onclick="document.getElementById('addInventoryModel').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            <h2>Add Inventory</h2>
        </header>
        <div class="w3-padding">
            <!-- <form action="../../Controller/admin/importCsv.php" method="post" enctype="multipart/form-data"> -->
            <div id="deviceImei">
                <label class="w3-text-color">Please enter Device IMEI</label>
                <input class="w3-input w3-border" id="inventory-imei" placeholder="IMEI Here" type="text">
                <center>or</center>
            </div>
            <div id="uploadCsv">
                <input type="file" id="file" accept=".csv" style="width:230px">
                <label for="file">(.csv file only)</label>
                <button id="buttonClear" onclick="clearFileInput()" style="background-color: #f44336;color:white;display:none">X</button>
            </div>
            <input type="submit" class="w3-red w3-button w3-section w3-col s12 m12 l12 m8-fancy" name="importSubmit" value="save" id="buttonshape" onclick="saveInventory()"></input>
            <!-- </form> -->
        </div>
    </div>
</div>
<div id="id05" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width:400px;height:auto;height:200px;">
        <header class="w3-container w3-color">
            <span onclick="document.getElementById('id05').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            <h2>Delete ?</h2>
        </header>
        <div class="w3-padding">
            <label class="w3-text-color">Type security Key</label>
            <input class="w3-input w3-border" id="skey" placeholder="Security Key Here" type="text">
            <button class="w3-red w3-button w3-section w3-col s12 m12 l12 m8-fancy" onclick='deleteAllDevice();'>Delete</button>
        </div>
    </div>
</div>

<div id="idDeleteDevice" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width:400px;height:auto;height:200px;">
        <header class="w3-container w3-color">
            <span onclick="document.getElementById('idDeleteDevice').style.display='none'" class="w3-button w3-display-topright">&times;</span>
            <h2 id="deleteDeviceH2"></h2>
        </header>
        <div class="w3-padding" id="deleteDeviceButton">
        </div>
    </div>
</div>
<!-- <div id="txtHint"><b>Inventory info will be listed here...</b></div> -->
<script>
    var result = [];
    var selectedImei = "";
    var inventoryArr = [];
    var timerId;
    w3.id("id01").style.height = (document.documentElement.clientHeight - 290) + "px";

    const fileInput = document.querySelector('input[type="file"]');
    fileInput.addEventListener('change', function(e) {
        e.preventDefault();
        const reader = new FileReader();
        reader.onload = function() {
            const lines = reader.result.split('\n').map(function(line) {
                return line.split(' ');
            })
            console.log('data read from file', lines);
            w3.id("buttonClear").style.display = "inline-block";
            parseData(lines);
        }
        reader.readAsText(fileInput.files[0]);
    }, false)


    function parseData(csvData) {
        inventoryArr = [];
        for (var i = 1; i < csvData.length; i++) {
            inventoryArr.push(csvData[i][0]);
        }
        var changeCsv = (inventoryArr.toString());
        // console.log(changeCsv);

    }

    function addInventory() {
        w3.id('addInventoryModel').style.display = "block";
        //alert("Add inventory called");
    }

    function handleFileInputChange() {
        var fileInput = document.getElementById("file");
        var clearButton = document.getElementById("buttonClear");

        if (fileInput.value != "") {
            clearButton.style.display = "inline";
        } else {
            clearButton.style.display = "none";
        }
    }

    function clearFileInput() {
        var fileInput = document.getElementById("file");
        fileInput.value = "";
        w3.id("buttonClear").style.display = "none";
        handleFileInputChange();
    }

    function inventorySearch(search = '') {
        let xhr = new XMLHttpRequest();
        clearTimeout(timerId);
        timerId = setTimeout(function() {
            xhr.open("GET", "../Controller/admin/inventorySearch.php?search=" + search);
            xhr.onload = function() {
                // console.log("result:", xhr.responseText);
                var result = xhr.responseText;
                w3.displayObject("InvData", JSON.parse(result));
            }
            xhr.send();
        }, 1000);

    }
    inventorySearch();

    function saveInventory() {
        sw();
        var deviceIMEI = w3.id("inventory-imei").value;
        if (deviceIMEI == "" && inventoryArr.toString() == "") {
            alert("Enter Device IMEI or Choose a file");
        } else if (deviceIMEI != "" && inventoryArr.toString() != "") {
            alert("Enter only one field");
        } else {
            var postData = deviceIMEI;
            if (inventoryArr.toString() != "") {
                postData = inventoryArr.toString();
            }
            var url = "../Controller/addInventory.php?imei=" + postData;
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                w3.id('addInventoryModel').style.display = "none";
                if (this.responseText == "1") {
                    alert("Device added successfully");
                    window.location.reload();
                } else if (this.responseText == "2") {
                    alert("Device already exist");
                } else {
                    alert("Error, Please try again");
                }
                sw();
            }
            xhttp.open("GET", url);
            xhttp.send();
        }
    }

    function getLog(deviceImei) {
        selectedImei = deviceImei;
        sw();
        // var deviceIMEI = w3.id("inventory-imei").value;
        var url = "../Controller/admin/getDetails.php?imei=" + deviceImei;
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            //  console.log(this.responseText);
            var res = this.responseText;
            var resInventory = JSON.parse(res);
            result = resInventory.result;
            w3.id('txtHint').style.display = "block";

            result = Object.keys(result).map((key) => result[key]);
            myObject = JSON.parse('{"result":' + JSON.stringify(result) + '}');

            w3.displayObject("id01", myObject);
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0;
            document.getElementById("deleteBtnTop").style.display = "block";
            sw();
            get2_bak("../Controller/admin/getDetails2.php?imei=" + deviceImei);
        }
        xhttp.open("GET", url);
        xhttp.send();
    }
   
    function get2_bak(url) {
		const xhttp = new XMLHttpRequest();
		xhttp.onload = function() {
			var res = this.responseText;
			var r = JSON.parse(res);
			locationLatLng = r.locationLatLng;
			//w3.id("remark").innerHTML = r.remark;
			try {
				var batt_status = document.getElementById('battery-fault');
				if (r.Bfault == "1") {
					batt_status.className = "fa fa-circle w3-text-red";
					batt_status.innerHTML = " ERR";
				} else {
					batt_status.className = "fa fa-circle w3-text-green";
					batt_status.innerHTML = " OK";
				}
				var panel_status = document.getElementById('panel-fault');
				if (r.Pfault == "1") {
					panel_status.className = "fa fa-circle w3-text-red";
					panel_status.innerHTML = " ERR";
				} else {
					panel_status.className = "fa fa-circle w3-text-green";
					panel_status.innerHTML = " OK";
				}
				var lumi_status = document.getElementById('luminary-fault');
				if (r.Pfault == "1") {
					lumi_status.className = "fa fa-circle w3-text-red";
					lumi_status.innerHTML = " ERR";
				} else {
					lumi_status.className = "fa fa-circle w3-text-green";
					lumi_status.innerHTML = " OK";
				}
				var sys_status = document.getElementById('system-status');
				if (r.Bfault == "1" || r.Lfault == "1" || r.Pfault == "1") {
					sys_status.className = "fa fa-circle w3-text-red";
					sys_status.innerHTML = " ERR";
				} else {
					sys_status.className = "fa fa-circle w3-text-green";
					sys_status.innerHTML = " OK";
				}

				const batteryfaultDT = r.BfaultDT;
				const cleanBatteryData = parseInt(batteryfaultDT.replace(/[\s-:]/g, ''));
				const panelfaultDT = r.PfaultDT;
				const cleanPanelData = parseInt(panelfaultDT.replace(/[\s-:]/g, ''));
				const lumifaultDT = r.LfaultDT;
				const cleanlumiData = parseInt(lumifaultDT.replace(/[\s-:]/g, ''));

				const maximum = Math.max(cleanBatteryData, cleanPanelData, cleanlumiData);
				var faultTimeDate = document.getElementById('fault');
				
				if(maximum == cleanBatteryData){
					faultTimeDate.innerHTML = batteryfaultDT;
				}else if(maximum == cleanPanelData){
					faultTimeDate.innerHTML = panelfaultDT;
				}else {
					faultTimeDate.innerHTML = lumifaultDT;
				}
				
				const batteryResolve = r.BfaultR;
				const cleanBatteryResolve = parseInt(batteryResolve.replace(/[\s-:]/g, ''));		
				const panelResolve = r.BfaultR;
				const cleanPanelResolve = parseInt(panelResolve.replace(/[\s-:]/g, ''));		
				const luminaryresolve = r.BfaultR;
				const cleanLuminaryResolve = parseInt(luminaryresolve.replace(/[\s-:]/g, ''));		
				
				const maximumResolve = Math.max(cleanBatteryResolve, cleanPanelResolve, cleanLuminaryResolve);
				console.log(maximumResolve);
				var resolvedTimeDate = document.getElementById('resolved');
				
				if(maximumResolve == cleanBatteryResolve){
					resolvedTimeDate.innerHTML = batteryResolve;
				}else if(maximumResolve == cleanPanelResolve){
					resolvedTimeDate.innerHTML = panelResolve;
				}else{
					resolvedTimeDate.innerHTML = luminaryresolve;
				}
				


				w3.id("onTime").innerHTML = r.onTime;
				w3.id("offTime").innerHTML = r.offTime;
				w3.id("Bfault").innerHTML = r.BfaultDT;
				w3.id("Pfault").innerHTML = r.PfaultDT;
				w3.id("LfaultD").innerHTML = r.LfaultD;
				w3.id("LfaultT").innerHTML = r.LfaultT;
				// w3.id("fault").innerHTML = r.fault;
				// w3.id("resolved").innerHTML = r.resolved;
				w3.id("remark").innerHTML = r.remark;


			} catch (e) {}
		}
		xhttp.open("GET", url);
		xhttp.send();
	}

    function deleteSingleDevice() {
        sw();
        var url = "../Controller/admin/deleteInventory.php?imei=" + selectedImei;
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            sw();
            if(res == "1"){
                alert("Deleted successfully");
                window.location.reload();
            }else{
                alert("Invalid request");
            }
        }
        xhttp.open("GET", url);
        xhttp.send();
    }

    function deleteAllDevice(){
        var security_key = w3.id('skey').value;

        sw();
        var url = "../Controller/admin/deleteInventory.php?imei=all&security_key="+security_key;
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            sw();
             var res = this.responseText;
            console.log(res);
            if(res == "1"){
                alert("Deleted successfully");
                window.location.reload();
            }else{
                alert("Invalid request");
            }
        }
        xhttp.open("GET", url);
        xhttp.send();
    }
</script>
