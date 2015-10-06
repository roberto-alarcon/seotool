<?php 
include_once(dirname(__FILE__).'/../config.php');
// Clase HTML para extraer informacion de una pagina web

class HTML {
	
	var $_url;
	var $_buffer_page;
	
	public function __construct( $url ){
	
		$this->_url = $url;
		$this->_buffer_page = file_get_contents($this->_url);
		
		
	}
	
	
	// Obtenemos el titulo 
	public function getTitle(){
		
		
	}
	
	// Obtenemos descripcion()
	public function getDescription(){
		
		
	}
	
	// Obtenemos los keywords
	public function getKeywords(){
		
		
	}
	
	
}


//$html = new HTML('http://www2.esmas.com/salud/');

if ($html = file_get_contents("http://www2.esmas.com/salud/elige-estar-bien-contigo/", true) ){

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

echo "Title: $title". '<br/><br/>';
echo "Description: $description". '<br/><br/>';
echo "Keywords: $keywords";
}else{
	
	echo 'error 404';
}
 
 



?>