<?php
require_once ("ActionOnApplication.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // FETCH
    if(isset($_GET['leave_application_id']) && isset($_GET['allData'])) {
        $actionOnApplication = ActionOnApplication::getByLeaveApplicationId( issetGetValue('leave_application_id') );
        $allData = [];
        $allData['action_on_application'] = $actionOnApplication;
        if($actionOnApplication->school_head_approved != null) {
            $allData['school_head_approved'] = $actionOnApplication->Recommendation();
        }
        if($actionOnApplication->hr_approved != null) {
            $allData['hr_approved'] = $actionOnApplication->CertificationOfLeaveCredits();
        }
        if($actionOnApplication->division_head_approved != null) {
            $allData['division_head_approved'] = $actionOnApplication->OSDSAction();
        }
        echo json_encode( $allData );

    } else if( isset($_GET['leave_application_id']) && isset($_GET['status']) ) {
        $aoa = ActionOnApplication::getByLeaveApplicationId( issetGetValue('leave_application_id') );
        if($aoa->id > 0) {
            echo json_encode($aoa->getStatus());
        } else {
            echo json_encode('Not Exists!');
        }
    } else if(isset($_GET['leave_application_id'])) {
        echo json_encode( ActionOnApplication::get( issetGetValue('leave_application_id') ) );
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // INSERT
}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // UPDATE
}
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // DELETE => use GET
}