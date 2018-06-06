<?php


/*
$filename = md5( date('l jS \of F Y h:i:s A') . rand()  );

$myfile = fopen("attachments/" . $filename  , "x");

$fileContent = "Hello world";
fwrite($myfile, $fileContent);

fclose($myfile);
*/

date_default_timezone_set('America/New_york');
echo date('Y-m-d');