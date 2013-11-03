<?php

	if($_POST['street']){
		$columns="page_id, type, website, location.street, location.latitude";
		$table="page";	
		$condition="name='".$_POST['name']."' and location.street != ''";
		
		$fql = "SELECT $columns from $table where $condition";	
		//echo $fql."<br>";
		$url="https://api.facebook.com/method/fql.query?query=".urlencode($fql)."&format=json";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$body = curl_exec($ch);
		curl_close($ch);
		$results = json_decode($body);
		
		//print_r($results);
		// now, process the JSON string
			
		if(!empty($results)){
			foreach($results as $result){
				similar_text($result->location->street,$_POST['street'],$percent);
					
				if($percent > 50){
					$page_id = $result->page_id;
					$website = $result->website;
					$type    = $result->type;			
					break;
				}
			}
		}
	}	
	else{
		$website=$_POST['website'];
		$type=$_POST['type'];
		$url = "https://graph.facebook.com/search?q=".urlencode($_POST['name'])."&type=page&limit=3";
		
		//echo $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$body = curl_exec($ch);
		curl_close($ch);

		// now, process the JSON string
		$json = json_decode($body);	
		//print_r($json);
		try{
			$result = $json->data;
			$pageno = count($result);//count the return page no. if more than 3
			//echo $pageno;
			//die();
			$result = $result[0];
		}catch(Exception $e){}
		
		if($result->id && $pageno<3){
			$page_id = $result->id;
			$type    = $result->category;
		}
		else
			$page_id=$_POST['id'];
	}
?>
<?php if(isset($page_id)):?>
	<iframe src="http://www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/pages/a/<?php echo $page_id;?>&amp;width=274&amp;colorscheme=light&amp;show_faces=true&amp;stream=true&amp;header=false&amp;" scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:274px; height:452px;" allowTransparency="false"></iframe>
	<?php

	echo "<p>";
	if(!empty($website))
	{
		if(strchr($website,"http"))
		{
			echo "<a href=\"$website\" target=\"_blank\">Go to Company Website</a><br>";
		}
		else
			echo "<a href=\"http://$website\" target=\"_blank\">Go to Company Website</a><br>";
	}
	
	if(isset($type))
		echo "Type:".$type."</p>";	
	?>
<?php else:?>
	<p>No Facebook Pages found!</p>
<?php endif;?>

	