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
    } else if( isset($_GET['admin_type_id']) && isset($_GET['status']) && isset($_GET['count'])) {
        if($_GET['admin_type_id'] == 2) {
            echo json_encode(ActionOnApplication::principalCount($_GET['status']));
        } else if($_GET['admin_type_id'] == 3) {
            echo json_encode(ActionOnApplication::hrCount($_GET['status']));
        } else if($_GET['admin_type_id'] == 4) {
            echo json_encode(ActionOnApplication::sdsCount($_GET['status']));
        }
    } else if(isset($_GET['admin_type_id']) && isset($_GET['status']) && isset($_GET['page'])) {
        echo json_encode(ActionOnApplication::leaveApplications($_GET['admin_type_id'], $_GET['status'], $_GET['page']));
    } else if(isset($_GET['leave_application_id'])) {
        echo json_encode( ActionOnApplication::get( issetGetValue('leave_application_id') ) );
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // INSERT
}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // UPDATE
    $input = json_decode(file_get_contents("php://input"));

    if(isset($input->leave_application_id) && isset($input->admin_type_id) && isset($input->approved)) {
        $actionOnApplication     = ActionOnApplication::getByLeaveApplicationId($input->leave_application_id);
        if($input->admin_type_id == 2) {
            $actionOnApplication->manualUpdate('school_head_approved', $input->approved);
            if($input->for > " ") {
                $recommendation     = $actionOnApplication->Recommendation();
                setApproval($recommendation, $input->approved, $input->for);
            }
        } else if($input->admin_type_id == 3) {
            $actionOnApplication->manualUpdate('hr_approved', $input->approved);
            if($input->for > " ") {
                $certificationOfLeaveCredits     = $actionOnApplication->CertificationOfLeaveCredits();
                setApproval($certificationOfLeaveCredits, $input->approved, $input->for);
            }
        } else if($input->admin_type_id == 4) {
            $actionOnApplication->manualUpdate('division_head_approved', $input->approved);
            if($input->for > " ") {
                $OSDSAction     = $actionOnApplication->OSDSAction();
                setApproval($OSDSAction, $input->approved, $input->for);
            }
        }
        echo json_encode('1');
    } else if( isset($input->leave_application_id) && isset($input->admin_type_id) && isset($input->reverse_action) ) {
        $actionOnApplication     = ActionOnApplication::getByLeaveApplicationId($input->leave_application_id);
        if($input->admin_type_id == 2) {
            $actionOnApplication->manualUpdate('school_head_approved', 'NULL');
        } else if($input->admin_type_id == 3) {
            $actionOnApplication->manualUpdate('hr_approved', 'NULL');
        } else if($input->admin_type_id == 4) {
            $actionOnApplication->manualUpdate('division_head_approved', 'NULL');
        }
        echo json_encode('1');
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // DELETE => use GET
}

function setApproval($object, $approved, $for) {
    if($approved) {
        $object->approved_for         = $for;
    } else {
        $object->disapproved_due_to   = $for;
    }
    $object->as_of = Date("Y-m-d");
    $object->save();
}