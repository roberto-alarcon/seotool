<?php
include_once(dirname(__FILE__).'/../config.php');
include_once PATH_LIBS.'class.reportControl.php';


// Clase controladora de los titulos
Class Title extends reportControl{
		
	var $array_title_elements = array();
	var $db_cell			= 'title';
	var $db_cell_number	= 'title_number';
	
	// Metodo para obtener los titulo
	public function getSmallElements(){
		
		$mydb = new myDBC();
		$sql = "SELECT * FROM Report_content where id_Report = '$this->id_report' and title_number < 6 and code='200' order by publication_datetime DESC;";
		$result = $mydb->runQuery($sql);
		if(isset($result)){
			while( $row = mysqli_fetch_assoc($result) ){
		
		
				$this->array_title_elements[] = $row;
				
		
			}
		
		}
		
		return $this->array_title_elements;
		
	}
	
	public function getLongElements(){
			
		$mydb = new myDBC();
		$sql = "SELECT * FROM Report_content where id_Report = '$this->id_report' and title_number > 12 and code='200' order by publication_datetime DESC;";
		$result = $mydb->runQuery($sql);
		if(isset($result)){
			while( $row = mysqli_fetch_assoc($result) ){
	
	
				$this->array_title_elements[] = $row;
	
	
			}
	
		}
		
		return $this->array_title_elements;
	
	}
	
}
?>