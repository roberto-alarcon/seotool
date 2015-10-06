<?php
//header ("Content-Type:text/xml");
include_once(dirname(__FILE__).'/../../config.php');
include_once PATH_LIBS.'class.reportControl.php';

$report = new reportControl();
$report->id_report = $_GET['id'];
$report->double_title_tmp();