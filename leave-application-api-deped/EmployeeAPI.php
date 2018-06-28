<?php
require_once ("Employee.php");
require_once ("School.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if( isset($_GET['searchType']) && $_GET['searchType'] == 'name' && isset($_GET['first_name']) && isset($_GET['last_name']) ) {
    echo json_encode( Employee::searchByName($_GET['first_name'], $_GET['last_name']) );
} else if ( isset($_GET['searchType']) && $_GET['searchType'] == '*' ) {
    echo json_encode( Employee::getAll() );
} else {
    if(isset($_GET['id']) && isset($_GET['school'])) {
        $id = $_GET['id'];
        $response = [];
        $response['employee']   = Employee::getById($id);
        $response['school']     = School::getById($response['employee']['school_id']);
        echo json_encode( $response );
    } else if( isset($_GET['id']) && $_GET['id'] > 0 ) {
        $id = $_GET['id'];
        echo json_encode( Employee::getById($id) );
    }
}