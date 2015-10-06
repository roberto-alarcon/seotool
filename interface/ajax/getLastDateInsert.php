<?php 
include_once(dirname(__FILE__).'/../../config.php'); 
include_once PATH_LIBS.'class.reportControl.php';

$id = $_GET['id'];
$report = new reportControl();
$report->id_report = $id;
$fecha_unix = $report->getLastInsertDate();
$fecha_unix = $fecha_unix[0][ 'publication_datetime' ];

echo date('d-m-Y' , $fecha_unix);

?>