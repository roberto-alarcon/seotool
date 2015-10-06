<?php
echo "welcome on line";
define("BD_USER", "root");
define("BD_PASSWORD", "AAKBgQCtNFZpXIDoab00ce0BeVe5Jqjgc+");
define("BD_DATABASE", "sistema_gascomb");
define("BD_SERVER", "localhost");
$bd = mysqli_connect(BD_SERVER, BD_USER, BD_PASSWORD, BD_DATABASE) or die("Error " . mysqli_error($bd));