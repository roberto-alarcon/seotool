<?php 
include_once(dirname(__FILE__).'/../../config.php');

$DB_Server = "localhost"; //MySQL Server
$DB_Username = BD_USER; //MySQL Username
$DB_Password = BD_PASSWORD;             //MySQL Password
$DB_DBName = BD_NAME;         //MySQL Database Name
$DB_TBLName = "Report_content"; //MySQL Table Name
$filename = "excelfilename";         //File Name

$id_Report = $_GET['id_Report'];
$type_consulta = $_GET['detail_grid'];

switch ($type_consulta){
	
	case 'small_title':
		$sql = "SELECT URL,title,title_number from $DB_TBLName where id_Report = '$id_Report' and title_number < 6 and code='200' order by publication_datetime DESC";
		$filename = "seo_report_titulos_cortos_id".$id_Report;
		break;
		
	case 'long_title':
		$sql = "SELECT URL,title,title_number from $DB_TBLName where id_Report = '$id_Report' and title_number > 12 and code='200' order by publication_datetime DESC";
		$filename = "seo_report_titulos_largos_id".$id_Report;
		break;
		
	case 'small_description':
		$sql = "SELECT URL,description,description_number from $DB_TBLName where id_Report = '$id_Report' and description_number < 12 and code='200' order by publication_datetime DESC";
		$filename = "seo_report_descripciones_cortas_id".$id_Report;
		break;
		
	case 'long_description':
		$sql = "SELECT URL,description,description_number from $DB_TBLName where id_Report = '$id_Report' and description_number > 24 and code='200' order by publication_datetime DESC";
		$filename = "seo_report_descripciones_largas_id".$id_Report;
		break;
		
	default:
		$sql = "SELECT URL,title,title_number from $DB_TBLName where id_Report = '$id_Report' and title_number < 6 and code='200' order by publication_datetime DESC";
		$filename = "seo_report_titulos_cortos_id".$id_Report;
		break;
	
	
}

print $sql;

//create MySQL connection
//$sql = "SELECT URL,title,title_number from $DB_TBLName where id_Report = '34' and description_number < 12 and code=200";
$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password) or die("Couldn't connect to MySQL:<br>" . mysql_error() . "<br>" . mysql_errno());
//select database
$Db = @mysql_select_db($DB_DBName, $Connect) or die("Couldn't select database:<br>" . mysql_error(). "<br>" . mysql_errno());
//execute query
$result = @mysql_query($sql,$Connect) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
$file_ending = "xls";
//header info for browser
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
/*******Start of Formatting for Excel*******/
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
for ($i = 0; $i < mysql_num_fields($result); $i++) {
	echo mysql_field_name($result,$i) . "\t";
}
print("\n");
//end of printing column names
//start while loop to get data
while($row = mysql_fetch_row($result))
{
	$schema_insert = "";
	for($j=0; $j<mysql_num_fields($result);$j++)
	{
		if(!isset($row[$j]))
			$schema_insert .= "NULL".$sep;
		elseif ($row[$j] != "")
		$schema_insert .= "$row[$j]".$sep;
		else
			$schema_insert .= "".$sep;
	}
	$schema_insert = str_replace($sep."$", "", $schema_insert);
	$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
	$schema_insert .= "\t";
	print(trim($schema_insert));
	print "\n";
}

?>