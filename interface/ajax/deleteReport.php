<?php
include_once(dirname(__FILE__).'/../../config.php'); 
include_once PATH_LIBS.'class.report.php';

try {
	$report = new Report();
	$report->id_report = $_POST["reporte_id"];
	$report->deleteReport();
	echo '{"result":"true"}';

}catch (Exception $e) {
	echo '{"result":"false"}';
}
	