
function showaddress()
{
		var address = document.getElementById('location').value;
		geocoder.getLatLng(
			address,
			function(point) {   
			  if (!point) {
				alert("Address: " + address + " not found");
			  } else {
			  	document.getElementById('latitude').value = point.lat().toString();
			  	document.getElementById('longitude').value = point.lng().toString();
			  	return true;
			  }
			}
	  );
		
}