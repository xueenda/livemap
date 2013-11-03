<div id="header">

<script type="text/javascript">
	// HTML5 get geo location

	function getLocation(){
		var location;
		if (navigator.geolocation)
	    {
	    	navigator.geolocation.getCurrentPosition(function(position){
	    		$('#latitude').val(position.coords.latitude);
	    		$('#longitude').val(position.coords.longitude);
	    	});
	    }
	  	else{
	  		x.innerHTML="Geolocation is not supported by this browser.";
	  	}

	  	return location;
	}


	$(document).ready(function(){
		getLocation();
		//console.log("Latitude: " + position.coords.latitude + "Longitude: " + position.coords.longitude);
	});

	
	function post(){
	
		if(document.getElementById('flag').value == 'true'){
			document.forms["searchForm"].submit();
			}
	}
	
	</script>
	<div class="search">
	
		<form id="searchForm" method="POST"  onsubmit="return checkFind();return showaddress();" action="<?php echo url::base();?>livemap/" >
	<!--
	<form method="POST"  onsubmit="getaccesstoken();" action="<?php echo url::base();?>livepage/" >
	-->
			<table>
			<tr>
			<td width="200px">
			<h3>Live Map</h3>
			</td>
			<td></td>
			<td>
				<a id="facebook-connect" href="<?php echo $auth_url?>"></a>
			</td>
			<!--
			<td>What</td> 
			<td>
			<input id="find" value="<?php echo isset($find)?$find:"restaurant"?>" name="find" autocomplete="off" maxlength="256" class="lss" title="Find what" size="30" spellcheck="true" onFocus="this.value=''">
			</td>
		-->
			<!--
			<td>Where</td>
			<td>
			<input id="location" value="<?php echo isset($location)?$location:""?>" type="text" onChange="return showaddress();" value="" style="" name="location" maxlength="100" class="lss" title="Address or zip code" size="10" onmouseup="clearText(this)">
			</td>
		-->
			<td>
				<!--
			<input id="latitude" name="latitude" type="hidden"  value="<?php echo isset($latitude)?$latitude:""?>" >
			<input id="longitude" name="longitude" type="hidden"  value="<?php echo isset($longitude)?$longitude:""?>" >
-->
			<input id="latitude" name="latitude" type="hidden"  value="">
			<input id="longitude" name="longitude" type="hidden"  value="">
			
			<input id="access_token" name="access_token" type="hidden" value="<?php echo isset($accessToken)?$accessToken:""?>">
			<input id="flag" type="hidden" value="false">
			</td>
			</tr>	
			</table>			
		</form>
	</div>

</div>