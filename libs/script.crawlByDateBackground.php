<?php
// 03/03/2014
// Roberto Alarcon
// roberto.alarcon@esmas.net
//include_once '../config.php';

/* Conexiones a la BD */
include_once 'class.mySQLi.php';


$id_report  		= $argv[1];
$domian				= $argv[2];
$path_repository	= PATH_REPOSITORY.$domian.'/'.$id_report.'/';
$reqhttpFile		= $path_repository.'_reqhttp.log';

// Actualizamos log a scaning
$mydb = new myDBC();
$sql = "UPDATE Report SET status='2' where id_Report =  '$id_report' ";
$mydb->runQuery($sql);



# Obtenemos la fecha mediante la lectura del archivo txt
$f = fopen($reqhttpFile, 'r');
$first_line = fgets($f);
fclose($f);
if( ! ini_get('date.timezone') )
{
	date_default_timezone_set('GMT');
}
if(!empty( $first_line)) {
	
	echo "***********************************************\n";
	echo "Start background process \n";
	
	$txt = explode('@', $first_line);
	$gsa_domian = $txt[0];
	$startdate	= $txt[1];
	$enddate	= $txt[2];

	
	$siguiente_dia = 0;
	$dia = 0;
	while( $siguiente_dia  <= $enddate ){
	
		$siguiente_dia = $startdate + ($dia * 24 * 60 * 60);
		$gsa_date_request = date('Y-m-d',$siguiente_dia);
		echo "\nScan :".$gsa_date_request."\n";
		/* Realizamos consulta a la API de GSA */
		$GSA_API = "http://googleak.esmas.com/search?q=site:".$gsa_domian."&btnG=Google+Search&access=p&client=pgeneral&output=xml_no_dtd&proxystylesheet=sitemap_td&oe=UTF-8&ie=UTF-8&ud=1&exclude_apps=1&site=default_collection&entqr=1&entqrm=0&sort=date%3AD%3AS%3Ad1&getfields=*&num=100&requiredfields=pubDate:".$gsa_date_request.".-urlFalsa";
		echo $GSA_API;
		echo "\n";
		if( $xml_gsa = @file_get_contents($GSA_API)){
		
			preg_match_all("#<loc>(.*)</loc>#",$xml_gsa, $out);
			if( isset($out[0]) && !empty($out[0]) ){
				foreach($out[0] as $url){
					$url = str_replace("<loc>", "", $url); $url = str_replace("</loc>", "", $url);
					echo "Crawling url: ".$url."\n";
					
					/*Realizamos el analisis de cada URL y la integramos a la BD */
					if($html = @file_get_contents($url)) {
						
						// Version 2.0 cambiamos lectura a DOMDocument de php
						$title = "";
						$description = "";
						$keywords = "";
						
						//$html = file_get_contents($url);
						
						//parsing begins here:
						$doc = new DOMDocument();
						@$doc->loadHTML($html);
						$nodes = $doc->getElementsByTagName('title');
						
						//get and display what you need:
						$title = $nodes->item(0)->nodeValue;
						
						$metas = $doc->getElementsByTagName('meta');
						
						for ($i = 0; $i < $metas->length; $i++)
						{
							$meta = $metas->item($i);
							if($meta->getAttribute('name') == 'Description' or $meta->getAttribute('name') == 'description')
								$description = $meta->getAttribute('content');
							if($meta->getAttribute('name') == 'Keywords' or $meta->getAttribute('name') == 'keywords')
								$keywords = $meta->getAttribute('content');
						}
						
					
						
						
						
						
						//$tags = get_meta_tags($url);
						
						// Notice how the keys are all lowercase now, and
						// how . was replaced by _ in the key.
						//echo $tags['author'];       // name
						//$title 				= utf8_encode ($tags['title']);
						
						if(!empty($title)){
							$title_num			= count(explode(' ',$title ));	
						}else{
							$title_num = 0;
						}
	
						
						//$description		= utf8_encode ($tags['description']);
						
						if(!empty($description)){
							$description_num	= count(explode(' ',$description ));
						}else{
							$description_num	= 0;
							
						}
						
						
						
						//$keywords			= utf8_encode ($tags['keywords']);
						if(!empty($keywords)){
							$keywords_num		= count(explode(',',$keywords ));
						}else{
							$keywords_num	= 0;
						
						}
						
						
						
						echo "Title : ".$title." ...\n";
						echo "Description : ".$description." ...\n";
						echo "Keywords : ".$keywords." ...\n";
						
						
						// Nos caonectamos a la BD tabla Report Control
						echo "Open database ...\n";
						$mydb = new myDBC();
						
						$title 				= $mydb->clearText($title);
						$description  		= $mydb->clearText($description);
						$keywords  			= $mydb->clearText($keywords);
						$code				= '200';
						$publication_date	= $siguiente_dia;
						
						$sql = "INSERT INTO Report_content (id_Report,URL,title,title_number,description,description_number,keywords,keywords_number,code,publication_datetime)
						VALUES ('$id_report','$url','$title','$title_num','$description','$description_num','$keywords','$keywords_num','$code','$publication_date'); ";
						$mydb->runQuery($sql);
						
						echo "Url crawled....\n";
						
						
					} else {
						
						$mydb = new myDBC();
						$code = '404';
						$sql = "INSERT INTO Report_content (id_Report,URL,code)
						VALUES ('$id_report','$url','$code'); ";
						$mydb->runQuery($sql);
						
						echo "Found 404 ....\n";
						 
						
					}
					
					
				}
				
				
			}
		}else{
			
			$mydb = new myDBC();
			$sql = "INSERT INTO Report_error (id_Report,URL)
			VALUES ('$id_report','$GSA_API'); ";
			$mydb->runQuery($sql);
			echo "Error al conectarse a la API ....\n";
			
		}
		
		$dia ++;
	
	}
	
	// Actualizamos log a scaning
	$mydb = new myDBC();
	$sql = "UPDATE Report SET status='3' where id_Report =  '$id_report' ";
	$mydb->runQuery($sql);
	
	echo "***********************************************\n";
	echo "End process \n";
	
}




?>