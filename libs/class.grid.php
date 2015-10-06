<?php
include_once(dirname(__FILE__).'/../config.php');
include_once PATH_LIBS.'class.title.php';
include_once PATH_LIBS.'class.description.php';

Class Grid {
	
	var $OBJ;
	var $reults;
	
	public function __construct( $OBJ ){
		
		$this->OBJ = $OBJ;
	}
	
	
	public function smallRange(){
		
		$this->results = $this->OBJ->getSmallElements();
		return $this->createTree();
		
	}
	
	public function longRange(){
		
		$this->results = $this->OBJ->getLongElements();
		return $this->createTree();
		
	}
	
	public function createTree(){
		
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<rows>';
		
		foreach ($this->results as $result ){
			
			$xml .= '<row id="'.$result['id_Report_content'].'">';
			$xml .= '<cell><![CDATA['.$result['URL'].'^'.$result['URL'].'^iframe_a]]></cell>';
			$xml .= '<cell><![CDATA['.$result[$this->OBJ->db_cell].']]></cell>';
			$xml .= '<cell>'.$result[$this->OBJ->db_cell_number].'</cell>';
			$xml .= '<cell>'.date('d-m-Y',$result['publication_datetime']).'</cell>';
			$xml .= '</row>';
		}
		
		$xml .= '</rows>';
		
		return $xml;
		 	
		
	}
	
	
}

?>