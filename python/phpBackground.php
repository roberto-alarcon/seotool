<?php
include_once(dirname(__FILE__).'/../config.php');
$id = '28';
$var1 = escapeshellcmd($id);
$domian = "http:__www2.esmas.com_entretenimiento_musica";
$var2 = escapeshellcmd($domian);

$out_file = escapeshellcmd("/Applications/XAMPP/htdocs/seo/repository/http:__www2.esmas.com_entretenimiento_musica/28/out.txt");
$error_file = escapeshellcmd("/Applications/XAMPP/htdocs/seo/repository/http:__www2.esmas.com_entretenimiento_musica/28/error.txt");


//exec("python crawlByDate.py $id $domian");
$mystring = system('php archivo.php '.$var1.' '.$var2.' >'.$out_file.'2>'.$error_file.' &', $retval);
echo "listo y seguimos operando ";