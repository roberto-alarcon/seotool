<?php
include_once(dirname(__FILE__).'/../config.php');
include_once PATH_LIBS.'class.report.php';

Class reportControl extends Report{
		
	
	public function totalRowsFound(){
		
		$mydb = new myDBC();
		return $mydb->totalCount('id_Report_content','Report_content','where id_Report='.$this->id_report);		
		
	}
	
	public  function totalSmallTitle(){
		
		$mydb = new myDBC();
		return $mydb->totalCount('id_Report_content','Report_content','where id_Report='.$this->id_report.' and title_number < 6');
		
	}
	
	public  function totalLongTitle(){
	
		$mydb = new myDBC();
		return $mydb->totalCount('id_Report_content','Report_content','where id_Report='.$this->id_report.' and title_number > 12');
	
	}
	
	public  function totalSmallDescription(){
	
		$mydb = new myDBC();
		return $mydb->totalCount('id_Report_content','Report_content','where id_Report='.$this->id_report.' and description_number < 12');
	
	}
	
	public  function totalLongDescription(){
	
		$mydb = new myDBC();
		return $mydb->totalCount('id_Report_content','Report_content','where id_Report='.$this->id_report.' and description_number > 24');
	
	}
	
	public  function totalError(){
	
		$mydb = new myDBC();
		return $mydb->totalCount('id_Report_content','Report_content','where id_Report='.$this->id_report.' and code = 404');
	
	}
	
	public function getDoubleTitle(){
		
		$double = array();
		$mydb = new myDBC();
		$sql = "SELECT id_Report_content,count(title) as 'NoRepeticiones',title 
				FROM Report_content where id_Report = $this->id_report
				GROUP BY title 
				HAVING COUNT(title)>1 ";
		
		$result = $mydb->runQuery($sql);
		if(isset($result)){
			while( $row = mysqli_fetch_assoc($result) ){
		
				$double[] = $row;
				
		
			}
		
		}
		
		return $double;
		
	}
	
	public function double_title_tmp(){
		
		$result = $this->getDoubleTitle();
		//print_r($result);
		
		foreach ($result as $value){
			
			print_r($value);
			$tmp_title = array();
			$mydb = new myDBC();
			$sql = "Select URL from Report_content where id_Report = '$this->id_report' and title = '$value[title]'";
			
			$result = $mydb->runQuery($sql);
			if(isset($result)){
				while( $row = mysqli_fetch_assoc($result) ){
			
					$tmp_title[] = $row;
			
			
				}
			
			}
			
			print_r($tmp_title);
			
		}
		
		
	}
	
	
	
	public function double_title_tree(){
		
		$result = $this->getDoubleTitle();
		
		$xml = "<?xml version='1.0' encoding='iso-8859-1'?>\n";
		$xml .= "<tree id='0'>\n";
		$xml .= "<item text='Titulos duplicados' id='root' im0='lock.gif' im1='lock.gif' im2='lock.gif'>\n";
		foreach ($result as $value){
			$xml .= '<item text="'.utf8_decode($value['title']).'" id="'.$value['id_Report_content'].'" im0="folderOpen.gif" im1="folderOpen.gif" im2="folderClosed.gif"></item>';
		
		
		}
			
		$xml .= "</item></tree>";
			
			
		echo $xml;
		
		
	}
	
	public function getTitleByIndentify( $identify ){
		
		$title = array();
		$mydb = new myDBC();
		$sql = "SELECT title
			FROM Report_content
			where id_Report_content = $identify ";
		$result = $mydb->runQuery($sql);
		if(isset($result)){
			while( $row = mysqli_fetch_assoc($result) ){
		
				$title[] = $row;
		
		
			}
		
		}
		
		return $title;
		
		
	}
	
	public function gridDoubleTitle( $identify ){
		
		$title = $this->getTitleByIndentify( $identify );
		if(!empty($title)){
			
			
			
			$grid = array();
			$mydb = new myDBC();
			$sql = "SELECT id_Report_content, URL
			FROM Report_content
			where title = '".$title[0]['title']."' and id_Report= $this->id_report ";
			
			
			$result = $mydb->runQuery($sql);
			if(isset($result)){
				while( $row = mysqli_fetch_assoc($result) ){
			
					$grid[] = $row;
			
			
				}
			
			}
			
			
		}
		
		
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<rows>';
		
		foreach($grid as $url){
			
			
			$xml .= '<row id="'.$url['id_Report_content'].'">';
			$xml .= '<cell><![CDATA['.$url['URL'].'^'.$url['URL'].'^iframe_a]]></cell>';
			$xml .= '</row>';
			
		}
		
		$xml .= '</rows>';
		
		echo $xml;
		
	}
	
	
	// Metodo para obtener la fecha del ultimo registro insertado
	public function getLastInsertDate(){
		
		$array_return = array();
		$mydb = new myDBC();
		$sql = "SELECT publication_datetime FROM Report_content where id_Report = '$this->id_report' order by publication_datetime desc limit 1;";
		$result = $mydb->runQuery($sql);
		if(isset($result)){
			while( $row = mysqli_fetch_assoc($result) ){
				
				$array_return[] = $row;
				
			}
			
		}
		
		return $array_return;
		
	}
	
	
	
	
	
}

?>
