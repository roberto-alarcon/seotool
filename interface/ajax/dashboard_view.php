<?php 
include_once(dirname(__FILE__).'/../../config.php'); 
include_once PATH_LIBS.'class.reportControl.php';

$id = $_GET['id'];
$report = new reportControl();
$report->id_report = $id;
$report->reportLoad();

$int_small_title = $report->totalSmallTitle();
$int_long_title = $report->totalLongTitle();
$int_small_description = $report->totalSmallDescription();
$int_long_description = $report->totalLongDescription();

?>

<html>
<head>
<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChartSmallTitle);
      google.setOnLoadCallback(drawChartLongTitle);
      google.setOnLoadCallback(drawChartSmallDescription); 
      google.setOnLoadCallback(drawChartLongDescription); 
      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChartSmallTitle() {

		var total_sitio = <?php echo $report->totalRowsFound();?>;
		var total_titulos_cortos = <?php echo $int_small_title;?>;
		var sitio = total_sitio - total_titulos_cortos;

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Sitio', sitio],
          ['error', total_titulos_cortos]
        ]);

        // Set chart options
        var options = {'title':'Titulos cortos',
                       'width':350,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }


      function drawChartLongTitle() {

  		var total_sitio = <?php echo $report->totalRowsFound();?>;
  		var total_titulos_largos = <?php echo $int_long_title;?>;
  		var sitio = total_sitio - total_titulos_largos;

          // Create the data table.
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Topping');
          data.addColumn('number', 'Slices');
          data.addRows([
            ['Sitio', sitio],
            ['Fuera de rango', total_titulos_largos]
          ]);

          // Set chart options
          var options = {'title':'Titulos largos',
                         'width':350,
                         'height':300};

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_div_long_title'));
          chart.draw(data, options);
        }

      function drawChartSmallDescription() {

    		var total_sitio = <?php echo $report->totalRowsFound();?>;
    		var total_description_cortos = <?php echo $int_small_description;?>;
    		var sitio = total_sitio - total_description_cortos;

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
              ['Sitio', sitio],
              ['Fuera de rango', total_description_cortos]
            ]);

            // Set chart options
            var options = {'title':'Descripciones cortas',
                           'width':350,
                           'height':300};

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div_small_description'));
            chart.draw(data, options);
          }

      function drawChartLongDescription() {

  		var total_sitio = <?php echo $report->totalRowsFound();?>;
  		var total_description_largas = <?php echo $int_long_description;?>;
  		var sitio = total_sitio - total_description_largas;

          // Create the data table.
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Topping');
          data.addColumn('number', 'Slices');
          data.addRows([
            ['Sitio', sitio],
            ['Fuera de rango', total_description_largas]
          ]);

          // Set chart options
          var options = {'title':'Descripciones largas',
                         'width':350,
                         'height':300};

          // Instantiate and draw our chart, passing in some options.
          var chart = new google.visualization.PieChart(document.getElementById('chart_div_long_description'));
          chart.draw(data, options);
        }
    

      
    </script>



<style type="text/css">

	table
	{
		
		overflow: auto;
		padding: 5px;
		font-family:"Courier New", Courier, monospace;
		font-size:12px;
		
	}

</style>

</head>
<body>

<h3>Bienvenidos al Dashboard</h3>

<table width="600px">
<tr>
	<td>ID Reporte </td>
	<td><?php echo $report->id_report;?></td>
</tr>
<tr>
	<td> Vertical / Canal </td>
	<td><?php echo $report->domain;?></td>
</tr>
<tr>
	<td>Reporte - fecha de inicio </td>
	<td><?php echo date('d-m-Y',$report->start_date);?></td>
</tr>
<tr>
	<td>Reporte - fecha fin </td>
	<td><?php echo date('d-m-Y',$report->end_date);?></td>
</tr>
<tr>
	<td>Fecha del crawl </td>
	<td><?php echo date('d-m-Y H:i:s',$report->array_report_elements[0]['creation_date']);?></td>
</tr>
<tr>
	<td>Urls scaneadas </td>
	<td><?php echo $report->totalRowsFound();?></td>
</tr>
<tr>
	<td>Titulos cortos </td>
	<td><?php echo $int_small_title;?></td>
</tr>
<tr>
	<td>Titulos largos </td>
	<td><?php echo $int_long_title;?></td>
</tr>
<tr>
	<td>Titulos duplicados </td>
	<td>campo</td>
</tr>
<tr>
	<td>Descripciones cortas </td>
	<td><?php echo $int_small_description;?></td>
</tr>
<tr>
	<td>Descripciones largas </td>
	<td><?php echo $int_long_description;?></td>
</tr>
<tr>
	<td>Descripciones duplicadas </td>
	<td>campo</td>
</tr>
<tr>
	<td>Errores 404 </td>
	<td><?php echo $report->totalError();?></td>
</tr>

</table>


<h3> Grafica titulos</h3>
<Table width=600px>

<tr>
<td><div id="chart_div"></div></td>
<td><div id="chart_div_long_title"></div></td>
</tr>
<tr>
<td></div></td>
<td></div></td>
</tr>

</Table>

<h3> Grafica descripciones</h3>
<Table width=600px>

<tr>
<td><div id="chart_div_small_description"></div></td>
<td><div id="chart_div_long_description"></div></td>
</tr>
<tr>
<td></div></td>
<td></div></td>
</tr>

</Table>




</body>
</html>