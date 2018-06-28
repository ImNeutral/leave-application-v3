<?php
require_once ("School.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');


if(isset($_GET['all'])) {
    $schools = School::getAll();
    echo json_encode($schools);
}