<!-- Header -->
<header class="w3-container w3-text-indigo" style="padding-top:22px">
	<h5><b><i class="fa fa-microchip"></i> Manage Device</b></h5>
</header>

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
		$tree = array("_g_data", "_f_device", "_e_ward", "_d_panchayat", "_c_block", "_b_district", "_a_project");
		if($branch > 6) $branch = 6;
		if($branch < 2) $branch = 2;
		$entry = strtolower(explode("_",$tree[$branch])[2]);

		$sql = "SELECT * FROM _f_device where ".$entry."='".$branch_value."' and active=0";
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
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
					<td><a href="https://www.google.com/maps/search/?api=1&query=<?php echo $row["lat"].",".$row["lng"]; ?>" target="_blank" class="w3-large"><i class="fa fa-globe w3-text-color"></i> Locate</a></a></td>
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
		}
		else
		echo "<tr><td>No new device found!</td></tr>";
		?>
	</table>
</div>

<script>
function authoriseDevice(imei)
{	
	var param  = "imei="+imei;
	ajax("../Controller/user/authoriseDevice.php",param,1);
}

function ajax(url,params,reload)
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
		{
			msg("Success!");
			if(reload>0)
			reload_on_close = 1;
		}
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
