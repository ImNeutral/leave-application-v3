<?php
require_once ("FileAttachment.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if( isset($_GET['filename']) ) {
    $fileName = $_GET['filename'];
    $file = new FileAttachment($fileName);
    echo json_encode($file->getContent());
}