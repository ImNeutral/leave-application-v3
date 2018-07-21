<?php
require_once ("FileAttachment.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');


if ($_SERVER['REQUEST_METHOD'] === 'GET') { // FETCH
    if (isset($_GET['filename'])) {
        $fileName = $_GET['filename'];
        $file = new FileAttachment($fileName);
        echo json_encode($file->getContent());
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Create
    $input = json_decode(file_get_contents("php://input"));
    if(isset($input->append) && isset($input->filename) && isset($input->content)) {
        $file = new FileAttachment($input->filename);
        $file->appendContent($input->content);
        echo json_encode(1);
    }
}

