<!-- Header -->
<header class="w3-container w3-text-indigo" style="padding-top:22px">
	<h5><b><i class="fa fa-globe"></i> Manage Location</b></h5>
</header>


<div class="w3-row w3-container">
  <div class="w3-half w3-padding">
	<div class="w3-container w3-white w3-card w3-round-large w3-text-color">
	  <h4><b>Add Location</b></h4>
	  
	  <label class="w3-text-color"><b>Select Type of Location</b></label>
	  <select class="w3-select w3-border w3-light-grey" id="addLocation_type">
		<option value="" disabled selected>Choose your option</option>
		<option value="1">District</option>
		<option value="2" disabled>Block</option>
		<option value="3" disabled>Panchayat</option>
		<option value="4" disabled>Ward</option>
	  </select>
	  
	  <label class="w3-text-color"><b>Name of Location</b></label>
	  <input class="w3-input w3-border w3-light-grey" type="text" id="addLocation_name">
	  
	  <label class="w3-text-color"><b>Parent Location</b></label>
	  <select class="w3-select w3-border w3-light-grey" id="addLocation_parent">
		<option value="" disabled selected>Choose your option</option>
		<option value="wam">wam</option>
	  </select>
	  
	  <button class="w3-button w3-white w3-border w3-border-color w3-round-large w3-section" onclick="addLocation()">Save</button>
	</div>
  </div>
  <div class="w3-half w3-padding">
	<div class="w3-container w3-white w3-card w3-round-large">
	  <h4>Rename Location</h4>
	</div>
  </div>
  <div class="w3-half w3-padding">
	<div class="w3-container w3-white w3-card w3-round-large">
	  <h4>Move Location</h4>
	</div>
  </div>
  <div class="w3-half w3-padding">
	<div class="w3-container w3-red w3-card w3-round-large">
	  <h4>Delete Location</h4>
	</div>
  </div>
</div>

<script>
function addLocation()
{
	var type   = w3.id("addLocation_type").value;
	var name   = w3.id("addLocation_name").value;
	var parent = w3.id("addLocation_parent").value;
	
	var param  = "type="+type+"&name="+name+"&parent="+parent;
	
	ajax("../Controller/admin/addLocation.php",param);
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
</script>