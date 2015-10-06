<?php
header ("Content-Type:text/xml");
include_once(dirname(__FILE__).'/../../config.php');
include_once PATH_LIBS.'class.report.php';

$report = new Report();
$report->domain = $_GET['site'];
$report->createXMLTree();