<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="shortcut icon" href="media/image/icon.ico"/>
  	<link rel="icon" type="image/gif" href="media/image/icon.gif" />
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="en-us" />
    <title><?php echo $title;?></title>
   
    <meta name="keywords" content="<?php echo $meta_keywords;?>" />
    <meta name="description" content="<?php echo $meta_description;?>" />
    <meta name="copyright" content="<?php echo $meta_copywrite;?>" />
    <?php foreach($styles as $file => $type) { echo HTML::style($file, array('media' => $type)), "\n"; }?>
    <?php foreach($scripts as $file) { echo HTML::script($file, NULL, FALSE), "\n"; }?>  
    <!--
   	<script src="http://cdn.wibiya.com/Toolbars/dir_0728/Toolbar_728731/Loader_728731.js" type="text/javascript"></script>
   	<noscript><a href="http://www.wibiya.com/">Web Toolbar by Wibiya</a></noscript>  
   -->
  	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=true&amp;key=<?php echo GOOGLE_MAP_KEY;?>" type="text/javascript"></script>
  	<script type="text/javascript" src="http://www.google.com/jsapi?key=<?php echo GOOGLE_MAP_KEY;?>"></script>
	<script> var site_url = '<?php echo SITE_PATH;?>';</script>
  	   </head>
  <body>
    <div id="wrapper">
     <?php echo $header;?>
     <?php echo $navigation;?>
     <?php echo $leftcolumn;?>
     <?php echo $content;?>
     <?php echo $footer;?>
    </div>
  </body>
</html>
