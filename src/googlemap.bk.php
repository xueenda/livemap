<?php defined('SYSPATH') OR die('No Direct Script Access');?>

        
<script type="text/javascript">
	var geocoder = new GClientGeocoder();

      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        
        <?php if(!empty($location['latitude'])):?>
			 // Create my location icon
			var blueIcon = new GIcon();
			blueIcon.shadow = "../image/home.png";

			blueIcon.iconSize = new GSize(32, 37);
			//blueIcon.shadowSize = new GSize(37, 34);
			blueIcon.iconAnchor = new GPoint(9, 34);
			blueIcon.infoWindowAnchor = new GPoint(9, 2);
			blueIcon.infoShadowAnchor = new GPoint(18, 25);
			
		    // Create GMarkerOptions object and show the marker
		    markerOptions = { icon:blueIcon };
			var mypoint= new GLatLng( <?php echo $location['latitude'].",".$location['longitude'];?>);
			var marker = new GMarker(mypoint, markerOptions);
			var myhome='My location';
			GEvent.addListener(marker, "click", function() {
			marker.openInfoWindowHtml(myhome);
          });

			map.addOverlay(marker);
			map.setCenter( mypoint , <?php echo $zoom;?>);
		<?php else:?>
			map.setCenter(new GLatLng(42, -95), 4);	
			
		<?php endif;?>
		
		var customUI = map.getDefaultUI();
		
        // Remove MapType.G_HYBRID_MAP
        customUI.maptypes.hybrid = false;
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
        function createMarker(point, message,overview) {
		
			var marker = new GMarker(point);
			GEvent.addListener(marker, "click", function() {
			loadleftcolumn(message);
			marker.openInfoWindowHtml(overview);
          });
		  
          return marker;
        }

		<?php
		
		if(!empty($pages)){
			//print_r($pages);
			$pagesnum=count($pages);
			for($i=0;$i<$pagesnum;$i++){
				$location=strtr($pages[$i]['location'],"\n\'\"","   ");
				$website=strtok($pages[$i]['website'],"\n");
				
				if(strpbrk($website," "))
				{
					$website="www.".$pages[$i]['name'].".com";
				}
					
				$message="page_url=".$pages[$i]['page_url']
						."&website=".$website
						."&type=".$pages[$i]['type'];
				
				if(!empty($googleResults[0]))
				{
					$overview="No overview.";
					foreach($googleResults as $result)
					{
						//there is some problem with the names
						if(strtolower($result->titleNoFormatting) == strtolower($pages[$i]['name']))
						{
							$overview = "<h4 style=\"margin-bottom:5px\"><a target=\"_blank\" href=\"$result->url\">$result->title</a></h4>";
							if(!empty($result->addressLines[0]))
									$overview = $overview.$result->addressLines[0]."<br>";
							if(!empty($result->addressLines[1]))		
									$overview = $overview.$result->addressLines[1]."<br>";
							if(!empty($result->phoneNumbers[0]->number))
									$overview = $overview.$result->phoneNumbers[0]->number."<br>";
							if(!empty($result->ddUrl))
									$overview = $overview."<a target=\"_blank\" href=\"$result->ddUrl\">Directions</a><br>";
							$overview=addslashes($overview);
						}
					}
									
					if(!empty($pages[$i]['latitude'])){
						?>
							var latlng = new GLatLng(  <?php echo $pages[$i]['latitude']?>,  <?php echo $pages[$i]['longitude']?> );
							map.addOverlay(createMarker(latlng,'<?php echo $message;?>','<?php echo $overview;?>'));
						<?php
						}
						else
						{	
						?>
							showAddress('<?php echo $location;?>','<?php echo $message;?>','<?php echo $overview;?>',<?php echo $pages[$i]['page_id']?>);
						<?php
						} 
				}
				else{
					//convert some characters in to space, this may cause javascrip function failure
					$token = strtr($pages[$i]['company_overview'],"\n\'\"","   ");
					
					if(empty($token))  
						$overview="No Company Overview provided!";
					else
						$overview="<div style=\"width:217px;height:80px;overflow:auto;\">".$token."</div>";
														
					if(!empty($pages[$i]['latitude'])){
					?>
						var latlng = new GLatLng(  <?php echo $pages[$i]['latitude']?>,  <?php echo $pages[$i]['longitude']?> );
						map.addOverlay(createMarker(latlng,'<?php echo $message;?>','<?php echo $overview;?>'));
					<?php
					}
					else
					{	
					?>
						showAddress('<?php echo $location;?>','<?php echo $message;?>','<?php echo $overview;?>',<?php echo $pages[$i]['page_id']?>);
			<?php
					} 
				}
			}
		}
		?>		
      }
      function showAddress(address,message,overview,page_id) {
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
		        	loadleftcolumn(message);   	
					marker.openInfoWindowHtml(overview);
		          });
		      }
		    }
		  );
		}
</script>
