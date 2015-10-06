<?php
include_once(dirname(__FILE__).'/../config.php');
include_once PATH_LIBS.'class.mySQLi.php';

Class Site {
	
	public $domain;
	
	// METODO ENCARGADO DE CREAR EL DIRECTORIO 
	public function createDomianDir(){
		
		$dir = str_replace("/", "_", $this->domain) ;
		if(!is_dir(PATH_REPOSITORY.$dir)){
			
			mkdir(PATH_REPOSITORY.$dir, 0777);
			
		}
		
	}

}

?>
