<?php 

// Assuming the above tags are at www.example.com
$tags = get_meta_tags('http://www2.esmas.com/entretenimiento/musica/fotos/alizee-la-francesita-mas-provocativa-esta-de-regreso/59899');

// Notice how the keys are all lowercase now, and
// how . was replaced by _ in the key.
//echo $tags['author'];       // name
echo $tags['title'];
echo '\n';
echo $tags['keywords'];
echo '\n';   // php documentation
echo $tags['description'];  // a php manual
//echo $tags['geo_position']; // 49.33;-86.59
?>
