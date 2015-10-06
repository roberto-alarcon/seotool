<?php 
header ("Content-Type:text/xml");
include_once(dirname(__FILE__).'/../../config.php');
include_once PATH_LIBS.'class.grid.php';

$type = $_GET['type'];
$action = $_GET['action'];
$id = $_GET['id'];


if(isset($type) && !empty($type)){
	
	switch($type){
		
		case "title":
			$obj = new Title();
			$obj->id_report = $id;
			
			if($action == 'small'){
				
				$grid = new Grid($obj);
				echo $grid->smallRange();
				break;
				
			}if($action == 'long'){
				
				$grid = new Grid($obj);
				echo $grid->longRange();
				break;
				
			}
			
		case "description":
			$obj = new Description();
			$obj->id_report = $id;
			
			if($action == 'small'){
			
				$grid = new Grid($obj);
				echo $grid->smallRange();
				break;
			
			}if($action == 'long'){
			
				$grid = new Grid($obj);
				echo $grid->longRange();
				break;
			
			}
		
	}
	
}


?>