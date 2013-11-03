function checkSearch(){
	
	var search = document.getElementById("search").value;
	if (search ==null || search =="")
	  {
		message = "Please enter the Facebook Page name!";
		alert(message);
		return false;
	  }
}

function checkFind(){
	var search = document.getElementById("find").value;
	var latitude = document.getElementById("latitude").value;
	if (search ==null || search =="")
	  {
		message = "What are you looking for?";
		alert(message);
		return false;
	  }
	if (latitude ==null || latitude =="")
	  {
		message = "Wait a second to parse the address. Please submit again. ";
		alert(message);
		return false;
	  }
}

function clearText(field){
    field.value = '';
    document.getElementById("latitude").value='';
	document.getElementById("longitude").value='';

}




/*
function clearText(field){
    if (field.defaultValue == field.value){
    	field.value = '';
    }
    	
    else if (field.value == '') field.value = field.defaultValue;
}
*/