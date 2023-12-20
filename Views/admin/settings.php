<!-- Header -->
<header class="w3-container w3-text-indigo" style="padding-top:22px">
	<h5><b><i class="fa fa-cog"></i> Settings</b></h5>
</header>

<div class="w3-row w3-container">
  <div class="w3-half w3-padding">
	<div class="w3-container w3-white w3-card m8-fancy w3-text-color">
	  <h4><b>Change update rate</b></h4>
	  
	  <label class="w3-text-color"><b>Update Rate (In Minutes)</b></label>
	  <input class="w3-input w3-border w3-light-grey m8-fancy" type="number" id="urate" min="1" max="999">
	  <button class="w3-button w3-color w3-border w3-border-color m8-fancy w3-section" onclick="urate()">Save</button>
	</div>
  </div>
  <div class="w3-half w3-padding">
	<div class="w3-container w3-white w3-card m8-fancy">
		<h4>Update Firmware</h4>
		<form action="../Controller/admin/upload.php" method="post" enctype="multipart/form-data" class="w3-section" onsubmit="event.preventDefault(); submitForm(this); return false;">
		  <label class="w3-text-color"><b>Firmware Version</b></label>
		  <input class="w3-input w3-border w3-light-grey m8-fancy" name="version" type="number" id="versn" min="1" max="9999">
		  <br>
		  <label class="w3-text-color"><b>Select BIN file to upload</b></label>
		  <input class="w3-input m8-fancy w3-light-grey w3-border" type="file" name="fileToUpload" id="fileToUpload">
		  <input class="w3-button w3-color w3-border w3-border-color m8-fancy w3-section" type="submit" value="Upload Firmware" name="submit">
		</form>
	</div>
  </div>
  <!---
  <div class="w3-half w3-padding">
	<div class="w3-container w3-white w3-card m8-fancy">
	  <h4>U2</h4>
	</div>
  </div>
  <div class="w3-half w3-padding">
	<div class="w3-container w3-red w3-card m8-fancy">
	  <h4>U3</h4>
	</div>
  </div>--->
</div>

<script>
w3.getHttpObject("../Controller/admin/getRate.php", function(text){
	var txt = text.toString();
	w3.id("urate").value = txt.slice(1, 4);
	w3.id("versn").value = txt.slice(4);
});

function submitForm(dform)
{
	var urate  = w3.id("urate").value;
	var versn  = w3.id("versn").value;
	
	if(urate > 999  || urate < 1 || urate.length!=3)
	{
		alert("Update rate should be in range of 001 to 999");
		return 1;
	}
	
	if(versn > 9999 || versn < 1 || versn.length!=4)
	{
		alert("Firmware version should be in range of 0001 to 9999");
		return 1;
	}
	
    var http = new XMLHttpRequest();
    http.onload = formSubmitted;
    http.open("post",dform.action);
    http.send(new FormData(dform));
}

function formSubmitted()
{
	if(this.status==200)
	{
		var res = this.response.split("$$");
		if(res[1]=="1")
		urate();
		else
		alert(res[0]);
	}
}

function urate()
{
	var urate  = w3.id("urate").value;
	var versn  = w3.id("versn").value;
	
	if(urate > 999  || urate < 1 || urate.length!=3) 
	{
		alert("Update rate should be in range of 001 to 999");
		return 1;
	}
	
	if(versn > 9999 || versn < 1 || versn.length!=4)
	{
		alert("Firmware version should be in range of 0001 to 9999");
		return 1;
	}
	
	var param  = "urate="+urate+"&versn="+versn;
	
	ajax("../Controller/admin/updateRate.php",param);
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