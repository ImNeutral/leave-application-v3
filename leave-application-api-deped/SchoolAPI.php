<?php
require_once ("Functions.php");
require_once ("School.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');


if(isset($_GET['all'])) {
    $schools = School::getAll();
    echo json_encode($schools);
} else if(isset($_GET['school_id']) && isset($_GET['employees']) ) {
    $schoolId   = secureString( $_GET['school_id']);
    $school     = School::get($schoolId);
    echo json_encode( $school->Employees() );
}

