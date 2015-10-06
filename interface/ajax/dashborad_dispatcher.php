<?php 
include_once(dirname(__FILE__).'/../../config.php');
include_once PATH_LIBS.'class.report.php';

$id = $_GET['id'];
$report = new Report();
$report->id_report = $id;
$report->reportLoad();
if( $report->status == 3  ){ // El reporte esta listo
	
	header('location:dashboard_view.php?id='.$report->id_report);
	
}else{
	
	header('location:dashboard_crawling.php?id='.$report->id_report);
}


?>