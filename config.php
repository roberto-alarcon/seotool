<?php
// Este es un archivo de configuracion

/* Hablitamos modo errores para entorno de desarrollo */
error_reporting(E_ALL);
ini_set("display_errors", 1);

/* Establecemos el tipo de codificacion */


/* Conexiones a la BD */
define("BD_USER", "root");
define("BD_PASSWORD", "AAKBgQCtNFZpXIDoab00ce0BeVe5Jqjgc+");
define("BD_NAME", "dbSEOTool");
define("BD_SERVER", "localhost");


/* Path absolutos */
define('PATH_LIBS',dirname(__FILE__).'/libs/');
define('PATH_REPOSITORY',dirname(__FILE__).'/repository/');
define('PATH_PYTHON',dirname(__FILE__).'/python/');


define('DOMAIN','http://seotool.gascomb.com');
define('DIR_DXTMLX',dirname(__FILE__).'/interface/dhtmlx/');
define('URL_DXTMLX',DOMAIN.'/interface/dhtmlx/');
define('URL_JS_LIBS',DOMAIN.'/interface/js_libs/');
?>