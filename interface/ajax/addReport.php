<?php
include_once(dirname(__FILE__).'/../../config.php'); 
include_once PATH_LIBS.'class.report.php';

try {
	
	$report = new Report();
	$report->domain = $_POST['site'];
	$report->start_date = strtotime($_POST['start']);
	$report->end_date = strtotime($_POST['end']);
	$report->addReport();
	echo '{"result":"true"}';
	
} catch (Exception $e) {
	echo '{"result":"false"}';
}
