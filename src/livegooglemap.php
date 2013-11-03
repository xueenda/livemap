<?php defined('SYSPATH') OR die('No Direct Script Access');

?>

<script type="text/javascript">
	var geocoder = new GClientGeocoder();

      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        <?php if(!empty($location['latitude'])):?>
        <?php $mylocation = $location['latitude'].",".$location['longitude'];
        //my location lat lng pair
        ?>
			 // Create my location icon
			var blueIcon = new GIcon();
			blueIcon.shadow = "../media/image/home.png";

			blueIcon.iconSize = new GSize(32, 37);
			//blueIcon.shadowSize = new GSize(37, 34);
			blueIcon.iconAnchor = new GPoint(9, 34);
			blueIcon.infoWindowAnchor = new GPoint(9, 2);
			blueIcon.infoShadowAnchor = new GPoint(18, 25);
			
		    // Create GMarkerOptions object and show the marker
		    markerOptions = { icon:blueIcon };
			var mypoint= new GLatLng(<?php echo $mylocation;?>);
			var marker = new GMarker(mypoint, markerOptions);
			var myhome='My location';
			GEvent.addListener(marker, "click", function() {
			marker.openInfoWindowHtml(myhome);
          });

			map.addOverlay(marker);
			map.setCenter( mypoint , <?php echo $zoom;?>);
		<?php else:?>
		
			loc=google.loader.ClientLocation;

			if (loc){
				
				if(loc.address.country_code=="CN"){
					alert("You are in China. Please come back via foreign proxy!");
				}
				
				latlng = new GLatLng(loc.latitude, loc.longitude);	
				document.getElementById("location").value= loc.address.city; 
				document.getElementById("latitude").value= loc.latitude; 
				document.getElementById("longitude").value= loc.longitude; 
				map.setCenter(latlng, 10);
			}else{
				map.setCenter(new GLatLng(42, -95), 4);
			}
 
		<?php endif;?>
		
		var customUI = map.getDefaultUI();
		
        // Remove MapType.G_HYBRID_MAP
        customUI.maptypes.hybrid = true;
       // customUI.MapTypeId.ROADMAP = true;
        map.setUI(customUI);

        // create shadow marker
		var baseIcon = new GIcon();
        baseIcon.shadow = "http://www.google.cn/mapfiles/shadow50.png";
        baseIcon.iconSize = new GSize(20, 34);
        baseIcon.shadowSize = new GSize(37, 34);
        baseIcon.iconAnchor = new GPoint(9, 34);
        baseIcon.infoWindowAnchor = new GPoint(9, 2);
        baseIcon.infoShadowAnchor = new GPoint(18, 25);

        //click marker
        function createMarker(point, message,overview,googleReview) {
		
			var marker = new GMarker(point);
			GEvent.addListener(marker, "click", function() {
			liveleftcolumn(message);
			
			marker.openInfoWindowHtml(overview);
			if(googleReview)
				loadGoogleReiew(googleReview);
          });
		  
          return marker;
        }

		<?php
		
		if(!empty($results)){
			//facebook place search result handle
			
			$fbResults=$results['fbResults'];
			
			foreach($fbResults as $fbResult){
				$location="";
				foreach($fbResult->location as $item)
					$location+= $item." ";
					
				$location=strtr($location,"\n\'\"","   ");
					
				$message="id=".$fbResult->id
						."&name=".urlencode($fbResult->name)
						."&type=".$fbResult->category;
						
				$googleReview="name=".addslashes($fbResult->name)
							."&latitude=".$fbResult->location->latitude
							."&longitude=".$fbResult->location->longitude
							."&mylocation=".$mylocation;
				
				$height=80+((int)(strlen($fbResult->name)/27))*10;
				
				$overview='<div id="googlereview" style="height:'.$height.'px"></div>';
														
					if(!empty($fbResult->location->latitude)){
					?>
						var latlng = new GLatLng(  <?php echo $fbResult->location->latitude?>,  <?php echo $fbResult->location->longitude?> );
						map.addOverlay(createMarker(latlng,'<?php echo $message;?>','<?php echo $overview;?>','<?php echo $googleReview;?>'));
					<?php
					}
					else
					{	
					?>
						showAddress('<?php echo $location;?>','<?php echo $message;?>','<?php echo $overview;?>',<?php echo $fbResult->id?>,'<?php echo $googleReview;?>');
					<?php
					} 
			}
			
			
			//google local search result handle
			$goResults=$results['googleResults'];
			
			foreach($goResults as $goResult){
				
				$message="name=".urlencode($goResult->titleNoFormatting)
						."&street=".$goResult->addressLines[0];
				
				$overview = "<div id=\"googlereview\"><h4 style=\"margin-bottom:5px\"><a target=\"_blank\" href=\"$goResult->url\">$goResult->title</a></h4>";
				if(!empty($goResult->addressLines[0]))
					$overview .= $goResult->addressLines[0]."<br>";
				if(!empty($goResult->addressLines[1]))		
					$overview .= $goResult->addressLines[1]."<br>";
				if(!empty($goResult->phoneNumbers[0]->number))
					$overview .= $goResult->phoneNumbers[0]->number."<br>";
				if(!empty($goResult->ddUrl))
					$overview .= "<a target=\"_blank\" href=\"$goResult->ddUrl\">Directions</a>";
				if(!empty($goResult->lat)){
					$latlng=$goResult->lat.",".$goResult->lng;
					$overview .= "&nbsp; &nbsp;<a target=\"_blank\" href=\"http://www.google.com/maps?layer=c&cbll=$latlng&cbp=0&ll=$latlng\">Street view</a><br></div>";
				}
				$overview=addslashes($overview);
				?>
				var latlng = new GLatLng(  <?php echo $goResult->lat?>,  <?php echo $goResult->lng?> );
				map.addOverlay(createMarker(latlng,'<?php echo $message;?>','<?php echo $overview;?>'));
			<?php											 
			}
		}
		?>		
      }
      function showAddress(address,message,overview,page_id,googleReview) {
		  geocoder.getLatLng(
		    address,
		    function(point) {   
		      if (!point) {
		        //alert("Address: " + address + " not found");
		      } else {
		      	text="page_id="+page_id
		      			+"&lat="+point.lat().toString()
		      			+"&lng="+point.lng().toString();
		      	
		      	//add the latitude and longitude to the specific page_id		
		      	addlatlng(text);  
		      	
		        var marker = new GMarker(point);
		        
		        map.addOverlay(marker);
		        GEvent.addListener(marker, "click", function() {
		        	liveleftcolumn(message);
					marker.openInfoWindowHtml(overview);
					loadGoogleReiew(googleReview);   
		          });
		      }
		    }
		  );
		}
</script>
	 