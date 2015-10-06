<?php
include_once(dirname(__FILE__).'/../config.php');

$id = '1';
$var1 = escapeshellcmd($id);
$domian = "http:__www2.esmas.com_entretenimiento_musica";
$var2 = escapeshellcmd($domian);

$out_file = escapeshellcmd(PATH_REPOSITORY."http:__www2.esmas.com_entretenimiento_musica/".$id."/out.txt");
$error_file = escapeshellcmd(PATH_REPOSITORY."http:__www2.esmas.com_entretenimiento_musica/".$id."/error.txt");


//exec("python crawlByDate.py $id $domian");
$mystring = system('php script.crawlByDateBackground.php '.$var1.' '.$var2.' >'.$out_file.'>'.$error_file.' &', $retval);

echo "listo y seguimos operando modulo clasees "; 