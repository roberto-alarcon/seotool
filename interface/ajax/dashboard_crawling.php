<?php 
include_once(dirname(__FILE__).'/../../config.php'); 
include_once PATH_LIBS.'class.report.php';

$id = $_GET['id'];
$report = new Report();
$report->id_report = $id;
$report->reportLoad();

$var1 = escapeshellcmd($id);
$domian = $report->cleanDomian();
$var2 = escapeshellcmd($domian);

$out_file = escapeshellcmd($report->id_reportDir."/out.txt");
$error_file = escapeshellcmd($report->id_reportDir."/error.txt");


// Ejecutamos proceso background
$mystring = system('php '.PATH_LIBS.'script.crawlByDateBackground.php '.$var1.' '.$var2.' >'.$out_file.'>'.$error_file.' &', $retval);

?>
<html>
<head>
<script src="<?php echo URL_JS_LIBS;?>jquery-1.11.0.min.js"></script>

<script>
function loadLog() {
	
	$('#log').html('Obteniendo datos...');
	//$('#LoadAlerts').html('');
	
	$.ajax({
		url: "getReportload.php?id="+<?php echo $report->id_report;?>,
		cache: false
	      }).done(function( html ) {
		$("#log").html(html);
	      });
	
	$.ajax({
		url: "getLastDateInsert.php?id="+<?php echo $report->id_report;?>,
		cache: false
	      }).done(function( html ) {
		$("#date").html(html);
	      });

	$.ajax({
		url: "getStatusLoad.php?id="+<?php echo $report->id_report;?>,
		cache: false
		})
		  .done(function( msg ) {
		   	if(  msg == "3" ){
		   			window.location = "./dashboard_view.php?id="+<?php echo $report->id_report;?>;
			   	}
		  });
    		
}

</script>

<style type="text/css">

	#log
	{
		border:1px solid #e2e2e2;
		height:80%;
		overflow: auto;
		padding: 5px;
		font-family:"Courier New", Courier, monospace;
		font-size:12px;
		
	}

</style>

</head>
<body>

<table border=0>

<tr>
<td width="100px"><img alt="" src="http://seotool.gascomb.com/interface/img/loading.gif" width="100%"></td>
<td valign="bottom"><h3>Un momento por favor.....  </h3> La entrega de este reporte puede tardar algunos minutos...  </td>
</tr>
</table>
Crawling status
<div id="date">
</div>
<div id="log">
<?php echo $report->getLog();?>
</div>

</body>
<script>

	timer = setInterval("loadLog()", 6000);
	
</script>
