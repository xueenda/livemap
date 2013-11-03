<!doctype html>
<html dir="ltr" lang="en-CA">
  <head>
    <meta charset="utf-8">
    <title>Livemap</title>
    <script type="text/javascript" src="<?php echo SITE_PATH.'media/js/jquery.min.js';?>"></script>
    <script type="text/javascript">
		function setCookie(c_name,value,exdays)
		{
			var exdate=new Date();
			exdate.setDate(exdate.getDate() + exdays);
			var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
			document.cookie=c_name + "=" + c_value + ";path=/";
		}
      $(document).ready(function() {
		setCookie("winClosed", 'true', 1); 
        window.close();
      });
    </script>
  </head>

</html>