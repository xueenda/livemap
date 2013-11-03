<?php
defined('SYSPATH') or die('No direct script access.');


class Model_SearchPage extends Kohana_Model
 {
 	//Append different facebook search result into one array
 	function appendArray($a,$b,$index)
 	{
 		if(empty($a))
 			return $b;
 		if(empty($b))
 			return $a;
 			
 		$length_a=count($a);
 		$length_b=count($b);
		
		for($i=0;$i<$length_b;$i++)
		{
			for($j=0;$j<$length_a;$j++)
			{
				if($b[$i][$index]==$a[$j][$index])
				{
					break;
				}			
			}	
			if($j<=$length_a)
				$a[$length_a+$i]=$b[$i];
    	}
    	return $a;
 	}
 	
	public function getFacebookPage($pagename)
    {
    	require './src/fbconnect.php';
    	
        $columns="page_id, name, pic_square, pic, page_url, type, website, founded, company_overview, mission, products, location, parking, public_transit, hours";
		$table="page";
		
		//first condition
		$condition="name='".$pagename."' and location.street+location.city != ''";
		$fql = "SELECT $columns from $table where $condition";		
		$pages_f = $facebook->api(array('method' => 'fql.query','query' =>$fql,));

		//second conditon
		$condition="name='".$pagename."' and location.latitude != ''";
		$fql = "SELECT $columns from $table where $condition";	
		$pages_s=$facebook->api(array('method' => 'fql.query','query' =>$fql,));
		$pages_fs=$this->appendArray($pages_f,$pages_s,"page_id");
		
		
		//third conditon
		$condition="name='".$pagename."' and location.zip != ''";
		$fql = "SELECT $columns from $table where $condition";	
		$pages_t=$facebook->api(array('method' => 'fql.query','query' =>$fql,));
		$pages_fst=$this->appendArray($pages_fs,$pages_t,"page_id");
		
		$pages=$pages_fst;
		
		/*
		$condition="name='".$pagename."' and location.street+location.zip+location.latitude != ''";
		$fql = "SELECT $columns from $table where $condition";	
		$pages=$facebook->api(array('method' => 'fql.query','query' =>$fql,));
		*/
		
		foreach($pages as $index => $item){
			$pages[$index]['latitude']='';
			$pages[$index]['longitude']='';
			foreach($item as $key => $value)
			{	
				if(is_array($value))
				{
					$sum="";
					foreach($value as $element => $detail)
					{
						if(!empty($detail))
							$sum.=$detail." ";
						if($element=='latitude')
							$pages[$index][$element]=$detail;
						if($element=='longitude')
							$pages[$index][$element]=$detail;
					}					
					$pages[$index][$key]=$sum;
				}
			}
		}	
		
		//insert search result into database
		$this->addPage($pages);	
	 	
	 	return $pages;
    }
  
     public function addPage($pages)
	 {
	 	//insert search result into database
		foreach($pages as $page)
	 	{
	 		try{
		 	DB::insert('page', array('page_id',
										'name',
										'pic_square',
										'pic',
										'page_url',
										'type',
										'website',
										'founded',
										'company_overview',
										'mission',
										'products',
										'location',
										'parking',
										'public_transit',
										'hours',
										'latitude',
										'longitude'))
	         ->values($page)
	         ->execute();
	 		}
	 		catch(Exception $e)
	 		{ 			
	 		}
	 	}	 
	}
 }