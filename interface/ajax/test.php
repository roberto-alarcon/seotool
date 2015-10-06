<?php
include_once(dirname(__FILE__).'/../../config.php');
include_once PATH_LIBS.'class.reportControl.php';

$tags = get_meta_tags('http://www2.esmas.com/mujer/fotos/las-mejores-formas-de-sacarle-una-sonrisa-a-tu-hijo/58979/');
print_r($tags);
echo $tags['title'].'<br>';




