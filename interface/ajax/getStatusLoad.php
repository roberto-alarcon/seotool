<?php 
include_once(dirname(__FILE__).'/../../config.php'); 
include_once PATH_LIBS.'class.report.php';

$id = $_GET['id'];
$report = new Report();
$report->id_report = $id;
$report->reportLoad();
echo $report->status;

?>