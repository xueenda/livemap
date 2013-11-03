<iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php echo $_POST['page_url'];?>&amp;width=274&amp;colorscheme=light&amp;show_faces=true&amp;stream=true&amp;header=false&amp;" scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:274px; height:452px;" allowTransparency="false"></iframe>

	<?php
		$website=$_POST['website'];
		$type=$_POST['type'];
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