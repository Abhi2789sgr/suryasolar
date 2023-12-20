<style>
.tableFixHead thead th {
	position: sticky;
	top: 0;
}
th {
	background: #ED1C24!important;
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
</style>
  
<!-- Header -->
<header class="w3-container w3-text-indigo" style="padding-top:22px">
	<h5><b onclick="history.back();" style="cursor:pointer;"><i class="fa fa-history"></i> <lable id="log_title">Log</lable></b><b> > <lable id="log_name"></lable></b></h5>
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

<div class="w3-container w3-responsive tableFixHead">
	<table id="id01" class="w3-table-all m8-fancy" style="overflow-y:scroll; overflow-x:scroll; height:400px;">
	  <thead>
	  <tr class="w3-color">
		<th>Date & Time</th>
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
		<!---<th>Locate</th>--->
	  </tr>
      </thead>
      <tbody>
	  <tr w3-repeat="result">
		<td>{{Time}}</td>
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
		<!---<td><a href="https://www.google.com/maps/search/?api=1&query=28.6052850,77.3898596" target="_blank" class="w3-large"><i class="fa fa-globe w3-text-color"></i></a></a></td>--->
	  </tr>
	  </tbody>
	</table>
</div>

<script>
function onStart()
{
	if(localStorage.temp_name!=undefined && localStorage.temp_imei!=undefined)
	{
		sw();
		w3.hide("#id01");
		var name = localStorage.temp_name;
		var imei = localStorage.temp_imei;
		w3.id("log_name").innerHTML = name;
		w3.id("log_name2").innerHTML = name;
		w3.id("log_imei").innerHTML = imei;
		w3.getHttpObject("../Controller/viewer/getLog.php?imei="+imei, myFunction);
		w3.id("id01").style.height= (document.documentElement.clientHeight - 300) + "px";
	}
	localStorage.back_enable = "1";
}

function myFunction(myObject)
{
	w3.displayObject("id01", myObject);
	var power = document.getElementsByClassName("power");
	var len = power.length;
	var pwr = "";
	for(var i=0;i<len;i++)
	{
		pwr = power[i].innerHTML;
		if(pwr<2)
		power[i].nextElementSibling.innerHTML = '<i class="fa fa-sun-o fa-plug0 w3-text-yellow w3-large"></i>';
		else
		power[i].nextElementSibling.innerHTML = '<i class="fa fa-battery-full w3-text-red w3-large"></i>';
	}
	w3.id("log_title").innerHTML = "Log";
	w3.hide(".extraDetails");
	w3.show("#id01");
	sw();
}
</script>
