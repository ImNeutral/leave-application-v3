<?php
require_once ("LeaveApplication.php");



if ($_SERVER['REQUEST_METHOD'] === 'GET') { // FETCH
    echo json_encode( LeaveApplication::get($_GET['id']) );
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // INSERT
    $input = json_decode(file_get_contents("php://input"));
    echo "<pre>";
    print_r($input);
}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // UPDATE
//    parse_str(file_get_contents("php://input"), $post_vars);
//    echo $post_vars['id'];

//    $input = json_decode(file_get_contents("php://input"));
//    echo json_encode( LeaveApplication::get( $input->id ) );
}
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // DELETE => use GET
    echo $_GET['id'];
//
}