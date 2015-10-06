<?php
include_once(dirname(__FILE__).'/../config.php');
include_once PATH_LIBS.'class.site.php';


Class Report extends Site{
	
	public $db_table;
	public $start_date	= 0;
	public $end_date = 0;
	public $id_report = 0;
	public $status;
	public $id_reportDir;
	public $array_report_elements = array();
	
	public function __construct() {
		$this->db_table = 'Report';
	}
	
	// METODO PARA OBTENER TODOS LOS ELEMENTOS
	public function reportLoad(){
		
		$mydb = new myDBC();
		$sql = "SELECT * FROM Report where id_Report = '$this->id_report' order by creation_date DESC;";
		$result = $mydb->runQuery($sql);
		if(isset($result)){
			while( $row = mysqli_fetch_assoc($result) ){
		
				$this->domain = $row['domain'];
				$this->start_date = $row['start_date'];
				$this->end_date	= $row['end_date'];
				$this->status	= $row['status'];
				
				$this->array_report_elements[] = $row;
				$this->getPathRepository();
		
			}
				
		}
		
	}
	
	public function getPathRepository(){
		$domain = str_replace("/", "_", $this->domain) ;
		$this->id_reportDir = PATH_REPOSITORY.$domain.'/'.$this->id_report;
		
		
	}
	
	public function cleanDomian(){
		
		return str_replace("/", "_", $this->domain) ;
		
	}
	
	
	public function getLog(){
		
		$domain = str_replace("/", "_", $this->domain) ;
		$this->id_reportDir = PATH_REPOSITORY.$domain.'/'.$this->id_report;
		$log = $this->id_reportDir . "/error.txt";
		$fichero = file_get_contents($log, true);
		return  nl2br ($fichero);
		
	}
		
	
	// METODO PARA CREAR EL DIRECTORIO DEL id_Report
	public function createIdReportDir(){
	
		$domain = str_replace("/", "_", $this->domain) ;

		$this->id_reportDir = PATH_REPOSITORY.$domain.'/'.$this->id_report;
		
		if(!is_dir($this->id_reportDir)){
				
			mkdir($this->id_reportDir, 0777);
				
		}
	
	}
	
	public function createLogFile(){
		
		$content = $this->domain."@".$this->start_date."@".$this->end_date;
		$fp = fopen($this->id_reportDir . "/_reqhttp.log","wb");
		fwrite($fp,$content);
		fclose($fp);
		
		// CAMBIAMOS LOS PERMISOS
		chmod($this->id_reportDir . "/_reqhttp.log", 0777);
		return true;
		
	}
	
	public function createOutputFile(){
		
		$content = "";
		$fp = fopen($this->id_reportDir . "/out.txt","wb");
		fwrite($fp,$content);
		fclose($fp);
		
		// CAMBIAMOS LOS PERMISOS
		chmod($this->id_reportDir . "/out.txt", 0777);
		return true;
		
	}
	
	public function createErrorFile(){
	
		$content = "";
		$fp = fopen($this->id_reportDir . "/error.txt","wb");
		fwrite($fp,$content);
		fclose($fp);
	
		// CAMBIAMOS LOS PERMISOS
		chmod($this->id_reportDir . "/error.txt", 0777);
		return true;
	
	}
	
	public function backGroundCrawl(){
		
		/*
		$domain = str_replace("/", "_", $this->domain) ;
		$id = $this->id_report;
		$var1 = escapeshellcmd($id);
		$var2 = escapeshellcmd($domain);
		
		
		$out_file = escapeshellcmd(PATH_REPOSITORY.$domain."/".$id."/out.txt");
		$error_file = escapeshellcmd(PATH_REPOSITORY.$domain."/".$id."/error.txt");
		
		
		//exec("python crawlByDate.py $id $domian");
		echo 'php script.crawlByDateBackground.php '.$var1.' '.$var2.' >'.$out_file.'>'.$error_file.' &';
		$mystring = system('php script.crawlByDateBackground.php '.$var1.' '.$var2.' >'.$out_file.'>'.$error_file.' &', $retval);
		*/
		
		$id = '1';
		$var1 = escapeshellcmd($id);
		$domian = "http:__www2.esmas.com_entretenimiento_musica";
		$var2 = escapeshellcmd($domian);
		
		$out_file = escapeshellcmd(PATH_REPOSITORY."http:__www2.esmas.com_entretenimiento_musica/".$id."/out.txt");
		$error_file = escapeshellcmd(PATH_REPOSITORY."http:__www2.esmas.com_entretenimiento_musica/".$id."/error.txt");
		
		
		//exec("python crawlByDate.py $id $domian");
		$mystring = system('php '.PATH_LIBS.'script.crawlByDateBackground.php '.$var1.' '.$var2.' >'.$out_file.'>'.$error_file.' &', $retval);
		
		echo "listo y seguimos operando modulo clasees ";
		
	}
	
	
	// METHOD ENCARGADO DE INSERTAR UN NUEVO REGISTRO
	public function addReport(){
		
		$mydb = new myDBC();
		
		$domain = $mydb->clearText($this->domain);
		$start  = $mydb->clearText($this->start_date);
		$end  = $mydb->clearText($this->end_date);
		$creation  = time();
		
		$sql = "INSERT INTO Report (domain,start_date,end_date,creation_date)
		VALUES ('$domain','$start','$end','$creation'); ";
		$mydb->runQuery($sql);
		$this->id_report = $mydb->lastInsertID();
		
		// Creamos directorios
		$this->createDomianDir(); // Directorio dominio o canal
		$this->createIdReportDir(); // Directorio del id_Report
		$this->createLogFile(); // Creamos el archivo del log
		$this->createOutputFile(); // Creamos archivo de salida para procesos background
		$this->createErrorFile(); // Creamos archivo para reporte de errores
		
		// Realizamos processo background de crawl
		//$this->backGroundCrawl();
		
		
		
		return  $this->id_report;
		
	}
	
	// Metodo para obtener todos los reportes
	public function getAllReports(){
		
		$array_return = array();
		$mydb = new myDBC();
		$sql = "SELECT * FROM Report where domain = '$this->domain' order by creation_date DESC;";
		$result = $mydb->runQuery($sql);
		if(isset($result)){
			while( $row = mysqli_fetch_assoc($result) ){
				
				$array_return[] = $row;
				
			}
			
		}
		
		return $array_return;
		
	}
	
	public function createXMLTree(){
		
		$rerults = $this->getAllReports();
		if(count($rerults) > 0 ){
			
			$xml = "<?xml version='1.0' encoding='iso-8859-1'?>\n";
			$xml .= "<tree id='0'>\n";
			$xml .= "<item text='Reportes' id='root' im0='lock.gif' im1='lock.gif' im2='lock.gif'>\n";
			foreach ($rerults as $value){
				$xml .= "<item text='".date('d/m/Y',$value['start_date'])." - ".date('d/m/Y',$value['end_date'])."' id='".$value['id_Report']."' im0='folderOpen.gif' im1='folderOpen.gif' im2='folderClosed.gif'></item>\n";
				
				
			}
			
			$xml .= "</item></tree>";
			
			
			echo $xml;
			
		}else{
			$xml = "<?xml version='1.0' encoding='iso-8859-1'?>\n";
			$xml .= "<tree id='0'>\n";
			$xml .= "<item text='Reportes' id='root' im0='folderOpen.gif' im1='folderOpen.gif' im2='folderClosed.gif'>\n";
			$xml .= "</item></tree>";
			
			echo $xml;
			
		}
		
		
	}
	
	
	public function deleteReport(){
		
		$mydb = new myDBC();
		$sql = "DELETE FROM Report where id_Report = '$this->id_report';";
		$sql2 = "DELETE FROM Report_content where id_Report = '$this->id_report';";
		$mydb->runQuery($sql);
		$mydb->runQuery($sql2);
		
	}
	
	
}

?>