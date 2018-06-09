<?php
require_once ("ActionOnApplication.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // FETCH
    if(isset($_GET['id'])) {
        echo json_encode( ActionOnApplication::get($_GET['id']) );
    } else if( isset($_GET['leave_application_id']) && isset($_GET['status']) ) {
        $aoa = ActionOnApplication::getByLeaveApplicationId($_GET['leave_application_id']);
        if($aoa->id > 0) {
            echo json_encode($aoa->getStatus());
        } else {
            echo json_encode('Not Exists!');
        }
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // INSERT
}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // UPDATE
}
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // DELETE => use GET
}