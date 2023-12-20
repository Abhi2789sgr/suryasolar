<header class="w3-container w3-text-indigo" style="padding-top:22px">
	<h5><b id="title" style="cursor:pointer;"><i class="fa fa-table"></i> History </b></h5>
</header>

<div class="w3-container w3-margin-bottom w3-row">
  <div class="w3-button w3-red w3-right w3-margin m8-fancy" id="deleteBtnTop" onclick="document.getElementById('id05').style.display='block'">Delete</div>
  <div class="w3-button w3-color w3-right w3-margin-top m8-fancy" id="addBtnTop" onclick="document.getElementById('id04').style.display='block'">Add Entity</div>
  <h2 id="heading"></h2>
  <div class="w3-row">
	  <div class="w3-center" id="addBtnCenter" style="display:none;margin:200px 0 200px 0;">
		<div class="w3-button w3-color w3-xlarge m8-fancy" onclick="document.getElementById('id04').style.display='block'">Add Entity Here</div>
	  </div>
	  <div class="w3-ul" id="id01" style="overflow-y:scroll; overflow-x:hidden; height:400px;">
		<div w3-repeat="result" class="w3-quarter w3-mobile" style="padding:5px;">
		  <div class="w3-bar w3-card w3-button m8-fancy">
			<div class="" style="text-align:left!important;" onclick="goHistory('{{Name}}','{{ID}}','{{Branch}}')">
			  <span class="w3-large">{{Name}}</span><br>
			  <span><small><label class="tot_devices">Total Devices: </label>{{DeviceCount}}</small></span>
			</div>
			<button class="w3-right m8-fancy w3-button" style="margin-top: -30px;"><i onclick="editName('{{Name}}','{{ID}}','{{Branch}}')" class="fa fa-edit"></i></button>
		  </div>
		</div>
	  </div>
	  <div class="w3-threequarter" style="display:none;" id="id03">
		<header class="w3-container w3-text-indigo" style="">
			<h5><b><i class="fa fa-history"></i> <lable id="log_title">Device Details</lable> > <lable id="log_name"></lable></b></h5>
		</header>
		<div class="w3-container">
			<div class="w3-card w3-white w3-margin-bottom w3-row m8-fancy">
				<div class="w3-row w3-color w3-center w3-padding m8-fancy">
					<div class="w3-col s6 m3 l3">
						<div><b>S.No. / D.Name</b></div>
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
				<div class="w3-container w3-padding w3-small" id="id02">
					<div class="w3-col s6 m3 l3 extraDetails" w3-repeat="result">
						<div class="{{b}}" id="{{b}}">{{a}}</div>
					</div>
				</div>
			</div>
			<div class="w3-row">
				<div class="w3-col s6 m3 l3" style="padding:5px;"><button class="w3-button w3-color m8-fancy" style="width:100%;" onclick='window.location.assign("?item=6")'><i class="fa fa-history"></i> Show Logs</button></div>
				<div class="w3-col s6 m3 l3" style="padding:5px;"><button class="w3-button w3-color m8-fancy" style="width:100%;" onclick='window.open("https://www.google.com/maps/search/?api=1&query="+locationLatLng, "_blank")'><i class="fa fa-map-marker"></i> Locate</button></div>
				<div class="w3-col s6 m3 l3" style="padding:5px;"><button class="w3-button w3-color m8-fancy" style="width:100%;" onclick='getImg();'><i class="fa fa-image"></i> Device Image</button></div>
				<div class="w3-col s6 m3 l3" style="padding:5px;"><button class="w3-button w3-color m8-fancy" style="width:100%;" onclick='window.open("/Controller/download.php?q="+w3.id("log_imei").innerHTML,"_blank");'><i class="fa fa-download"></i> Download</button></div>
			</div>
		</div>
	  </div>
  </div>
</div>

  <div id="model" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width:300px;">
      <header class="w3-container w3-color"> 
        <span onclick="document.getElementById('model').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2>Device Image</h2>
      </header>
      <div class="">
        <img class="w3-modal-content" src="" id="img" style="width:100%">
		<button class="w3-color w3-button w3-col s12 m12 l12" onclick="newTab()">Open Image In New tag</button>
      </div>
    </div>
  </div>

  <div id="id04" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width:400px;height:auto;height:500px;">
      <header class="w3-container w3-color"> 
        <span onclick="document.getElementById('id04').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2>Add Entity</h2>
      </header>
      <div class="w3-padding">
		<label class="w3-right w3-text-color" style="">Character Left: <span id="charLeft" class="w3-text-green">800</span></label>
		<label class="w3-text-color w3-large">Add Entity</label><br>
		<label class="w3-text-color">(Add each entity in every new line)</label>
        <textarea class="w3-input w3-text-color w3-border" id="entity" style="resize:none;height:320px;" onchange="countLen()" onkeydown="countLen()" onmouseout="countLen()"></textarea>
		<button class="w3-color w3-button w3-section w3-col s12 m12 l12 m8-fancy" id="addEntityBtn" onclick="addEntity()">Add</button>
      </div>
    </div>
  </div>

  <div id="id05" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4" style="width:400px;height:auto;height:200px;">
      <header class="w3-container w3-color"> 
        <span onclick="document.getElementById('id05').style.display='none'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2>Delete ?</h2>
      </header>
      <div class="w3-padding">
		<label class="w3-text-color">Type security Key</label>
        <input class="w3-input w3-border" id="skey" placeholder="Security Key Here" type="text">
		<button class="w3-red w3-button w3-section w3-col s12 m12 l12 m8-fancy" onclick="deleteEntity()">Delete</button>
      </div>
    </div>
  </div>

  <div id="editName" class="w3-modal">
	<div class="w3-modal-content w3-animate-top w3-card-4" style="width:400px;height:auto;height:200px;">
		<header class="w3-container w3-color">
			<span onclick="document.getElementById('editName').style.display='none'" class="w3-button w3-display-topright">&times;</span>
			<h2>Edit Devie Name</h2>
		</header>
		<div class="w3-padding">
			<label class="w3-text-color">Name</label>
			<input class="w3-input w3-border" id="dName" placeholder="Enter Name here" type="text">
			<div class="w3-padding" id="editDeviceButton">
			</div>
			<!-- <button class="w3-red w3-button w3-section w3-col s12 m12 l12 m8-fancy" onclick="updateDname()">Save</button> -->
		</div>
	</div>
</div>

<script>
const tree = ["_g_data", "_f_device", "_e_ward", "_d_panchayat", "_c_block", "_b_district", "_a_project"];
const color = ["w3-red", "w3-pink", "w3-purple", "w3-deep-purple", "w3-blue", "w3-teal", "w3-green", "w3-indigo", "w3-blue-grey", "w3-deep-orange"];
var title = w3.id("title");
var deleteBtnTop = w3.id("deleteBtnTop");
var heading = w3.id("heading");
var name_global = "";
var id_global = "";
var branch_global = "";
var imei = "";
var device_page = false;
var locationLatLng = "";
var countLength = 0;
var back_enable = 0;

w3.id("id01").style.height= (document.documentElement.clientHeight - 290) + "px";

goHistory("","","");

function newTab()
{
var img = w3.id("img").src;
var image = new Image();
image.src = img;

var w = window.open("");
w.document.write(image.outerHTML);
w.document.close();
}

function getImg()
{
	sw();
	document.getElementById('model').style.display='block';
	get("../Controller/user/getImg.php?imei="+imei);
	sw();
}

function setDetails(myObject)
{
	w3.displayObject("id02", myObject);
	get2_bak("../Controller/admin/getDetails2.php?imei="+imei);
	sw();
}

function myFunction(myObject)
{
	var result = myObject.result
	if(result[0].Name=='N/A') result = '';
	result = Object.keys(result).map((key) => result[key]);
	result.sort(sortByProperty("Name"));
	myObject = JSON.parse('{"result":'+JSON.stringify(result)+'}');

	w3.displayObject("id01", myObject);
	for(var i=0;i<color.length;i++)
	w3.removeClass('.w3-card.w3-button',color[Math.floor(Math.random() * 10)]);
	w3.addClass('.w3-card.w3-button',color[Math.floor(Math.random() * 10)]);
	var str = title.innerHTML;
	str = str.slice(0,str.indexOf('<a onclick="goHistory(&quot;'+name_global))
	title.innerHTML = str+" <a onclick='goHistory(\""+name_global+"\", \""+id_global+"\", \""+branch_global+"\")'>"+name_global+"</a> >";
	deleteBtnTop.innerHTML = "Delete All "+(tree[branch_global-1].split("_")[2]+"s").toLowerCase();
	heading.innerHTML = (tree[branch_global-1].split("_")[2]+" List").toUpperCase();
	scrollToTop();
	
	if(device_page)
	{
		var tot_devices = document.getElementsByClassName("tot_devices");
		for(var i=0;i<tot_devices.length;i++)
		{
			tot_devices[i].innerHTML="Device ID: ";
		}
		
		w3.id("id01").className += " w3-quarter";
		var div = w3.id("id01").getElementsByClassName("w3-mobile");
		for(var i=0;i<div.length;i++)
		div[i].className = "w3-mobile";
		w3.id("addBtnTop").style.display="none";
		w3.id("addBtnCenter").style.display="none";
		
		
		if(document.getElementsByClassName("tot_devices").length == result.length)
		{
			w3.id("addBtnCenter").style.display="none";
		}
		else
		{
			w3.id("addBtnCenter").style.display="none";
			w3.id("id01").style.display="none";
		}
	}
	else
	{
		w3.id("addBtnTop").style.display="block";
		w3.id("addBtnCenter").style.display="none";
		
		
		if(document.getElementsByClassName("tot_devices").length == result.length)
		{
			w3.id("addBtnCenter").style.display="none";
		}
		else
		{
			w3.id("id01").style.display="none";
			w3.id("addBtnCenter").style.display="block";
		}
	}
}

function goHistory(name, id, branch)
{
	if(branch==2)
	  device_page = true;
	else
	  device_page = false;
	
	var q = "";
	if(name=="" || id=="" || branch=="")
	{
		branch_global = branch = <?php echo $branch-1; ?>+1;
		name_global = "";
		id_global = "";
		if(localStorage.back_enable=="1")
		{
			back_enable = 1;
			branch = 0;
			w3.id("title").innerHTML = localStorage.title;
			localStorage.back_enable = "0";
			goHistory(localStorage.back_name, localStorage.back_id, localStorage.back_imei);
		}
	}
	else
	{
		if(branch>9999)
		{
			localStorage.temp_name = name;
			localStorage.temp_id   = id;
			localStorage.temp_imei = branch;
			
			w3.id("id03").style.display="block";
			sw();
			w3.id("log_name").innerHTML = name;
			w3.id("log_name2").innerHTML = name;
			w3.id("log_imei").innerHTML = branch;
			
			imei = branch;
			w3.getHttpObject("../Controller/user/getDetails.php?imei="+branch, setDetails);
			//get2_bak("../Controller/user/getDetails2.php?imei="+branch);
			branch = 0;
		}
		else if(branch>1)
		{
			if(back_enable != 1)
			{
				localStorage.back_name = name;
				localStorage.back_id   = id;
				localStorage.back_imei = branch;
				localStorage.title = w3.id("title").innerHTML;
				back_enable = 0;
			}
			
			w3.id("id03").style.display="none";
			q = "?branch="+(branch-1)+"&parent="+id;
			name_global = name;
			id_global = id;
			branch_global = branch;
		}
	}
	if(branch>1)
	{
		w3.getHttpObject("../Controller/user/getHistory.php"+q, myFunction);
	}
}

function scrollToTop()
{
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

function SortByName(x,y) {
  return ((x.Name == y.Name) ? 0 : ((x.Name > y.Name) ? 1 : -1 ));
}

function sortByProperty(property){  
   return function(a,b){  
      if(a[property] > b[property])  
         return 1;  
      else if(a[property] < b[property])  
         return -1;  
  
      return 0;  
   }  
}

function get(url) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    w3.id("img").src="data:image/png;base64,"+this.responseText;
  }
  xhttp.open("GET", url);
  xhttp.send();
}

function get2(url) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    var res = this.responseText;
	var r = JSON.parse(res);
	locationLatLng = r.locationLatLng;
	try{
		w3.id("onTime").innerHTML=r.onTime;
		w3.id("offTime").innerHTML=r.offTime;
		w3.id("Bfault").innerHTML=r.Bfault;
		w3.id("Pfault").innerHTML=r.Pfault;
		w3.id("Lfault").innerHTML=r.Lfault;
		w3.id("fault").innerHTML=r.fault;
		w3.id("resolved").innerHTML=r.resolved;
		
		w3.id("remark").innerHTML=r.remark;
		w3.id("updated_by").innerHTML=r.updated_by;
		w3.id("lastTime").innerHTML=r.lastTime;
		w3.id("installTime").innerHTML=r.installTime;
		w3.id("battery_qr").innerHTML=r.battery_qr;
		w3.id("panel_qr").innerHTML=r.panel_qr;
		
		var dtF = new Date(r.fault);
		var dtR = new Date(r.resolved);
		if(!(dtR-dtF>0))
		w3.id("resolved").innerHTML="--";
		
		var arr_flag = ["panel-fault","battery-fault","luminary-fault","system-status"];
		for(var i=0;i<3;i++)
		{
			if(r.flag[i+2]==1)
			{
				var lumFault = document.getElementsByClassName(arr_flag[i])[0];
				lumFault.className="fa fa-circle w3-text-red";
				lumFault.innerHTML=" ERR";
			}
			else
			{
				var lumFault = document.getElementsByClassName(arr_flag[i])[0];
				lumFault.className="fa fa-circle w3-text-green";
				lumFault.innerHTML=" OK";
			}
		}
		if(r.flag[2]==1||r.flag[3]==1||r.flag[4]==1)
		{
			var lumFault = document.getElementsByClassName(arr_flag[3])[0];
			lumFault.className="fa fa-circle w3-text-red";
			lumFault.innerHTML=" ERR";
		}
		else
		{
			var lumFault = document.getElementsByClassName(arr_flag[3])[0];
			lumFault.className="fa fa-circle w3-text-green";
			lumFault.innerHTML=" OK";
		}
	}catch(e){}
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
	try{
		w3.id("onTime").innerHTML=r.onTime;
		w3.id("offTime").innerHTML=r.offTime;
		w3.id("Bfault").innerHTML=r.Bfault;
		w3.id("Pfault").innerHTML=r.Pfault;
		w3.id("LfaultD").innerHTML=r.LfaultD;
		w3.id("LfaultT").innerHTML=r.LfaultT;
		w3.id("fault").innerHTML=r.fault;
		//w3.id("faultD").innerHTML=r.faultD;
		//w3.id("faultT").innerHTML=r.faultT;
		var dtF = new Date(r.fault);
		var dtR = new Date(r.resolved);
		if(!(dtR-dtF>0))
		r.resolved = "--";
		w3.id("resolved").innerHTML=r.resolved;
		
		var arr_flag = ["panel-fault","battery-fault","luminary-fault","system-status"];
		for(var i=0;i<3;i++)
		{
			if(r.flag[i+2]==1)
			{
				var lumFault = document.getElementsByClassName(arr_flag[i])[0];
				lumFault.className="fa fa-circle w3-text-red";
				lumFault.innerHTML=" ERR";
			}
			else
			{
				var lumFault = document.getElementsByClassName(arr_flag[i])[0];
				lumFault.className="fa fa-circle w3-text-green";
				lumFault.innerHTML=" OK";
			}
		}
		if(r.flag[2]==1||r.flag[3]==1||r.flag[4]==1)
		{
			var lumFault = document.getElementsByClassName(arr_flag[3])[0];
			lumFault.className="fa fa-circle w3-text-red";
			lumFault.innerHTML=" ERR";
		}
		else
		{
			var lumFault = document.getElementsByClassName(arr_flag[3])[0];
			lumFault.className="fa fa-circle w3-text-green";
			lumFault.innerHTML=" OK";
		}
	}catch(e){}
  }
  xhttp.open("GET", url);
  xhttp.send();
}

function addEntity()
{
	var entity = w3.id("entity").value.split("\n");
	var entity2 = "";
	for(var i=0;i<entity.length;i++)
	entity2 = entity2 + "$$" + entity[i];
	get3("../Controller/user/addEntity.php?branch_global="+branch_global+"&id_global="+id_global+"&entity="+entity2);
	sw();
}

function countLen()
{
	countLength = w3.id("entity").value.length + w3.id("entity").value.split("\n").length;
	w3.id("charLeft").innerHTML = 800-countLength;
	if(800-countLength>0)
		w3.id("charLeft").className="w3-text-green";
	else
		w3.id("charLeft").className="w3-text-red";
	
	if(countLength > 800 || countLength <1)
	{
		w3.id("addEntityBtn").disabled = true;
	}
	else
	{
		w3.id("addEntityBtn").disabled = false;
	}
}

function get3(url) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    if(this.responseText=="1")
	{
		goHistory(name_global,id_global,branch_global);
		w3.id('id04').style.display='none';
		w3.id("entity").value = "";
	}
	else
	alert("Error, Please try again");
	sw();
  }
  xhttp.open("GET", url);
  xhttp.send();
}

function deleteEntity()
{
	var skey = w3.id("skey").value;
	//get4("../Controller/user/deleteEntity.php?branch_global="+branch_global+"&id_global="+id_global+"&skey="+pass);
	var param  = "branch_global="+branch_global+"&id_global="+id_global+"&skey="+skey;
	ajax("../Controller/user/deleteEntity.php",param);
	w3.id("skey").value = "";
	w3.id('id05').style.display='none';
	setTimeout(function(){goHistory(name_global,id_global,branch_global);},2000);
}

function ajax(url,params)
{
	sw();
	if (window.XMLHttpRequest)
	  xmlhttp=new XMLHttpRequest();
	else
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.open("POST",url,true);
	xmlhttp.onreadystatechange=function()
	{
	  if (xmlhttp.readyState==4)
	  if (xmlhttp.status==200)
	  {
		if(xmlhttp.responseText=="1")
			msg("Success!");
		else
			msg("Some error occurred. Please try again later");
		sw();
	  }
	  else
		sw();
	}
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length",params.length);
	xmlhttp.setRequestHeader("Connection","close");
	xmlhttp.send(params);
}

function editName(name, id, parent) {
		w3.id("editName").style.display = "block";
		w3.id("dName").value = name;
		w3.id("editDeviceButton").innerHTML = '<button class="w3-red w3-button w3-section w3-col s12 m12 l12 m8-fancy" onclick="updateDname(' + id + ',' + parent + ')">Save</button>';
	}

	function updateDname(id, parent) {
		var value = document.getElementById('dName').value;
		var param = "name=" + value + "&id=" + id + "&branch=" + parent;
		ajax("../Controller/user/updateDevice.php", param);
		w3.id("editName").style.display = "none";
	
	}
</script>
