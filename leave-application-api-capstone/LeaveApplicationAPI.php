<?php
require_once ("LeaveApplication.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // FETCH
    if(isset($_GET['id'])) {
        $la     = LeaveApplication::get($_GET['id']);
        $la->status();
        echo json_encode( $la );
    } else if ( isset($_GET['count']) && isset($_GET['accountId']) ) {
        echo json_encode( LeaveApplication::count("WHERE account_id=" . $_GET['accountId']) );
    } else if( isset($_GET['page']) && isset($_GET['accountId']) ) {
        $where              = " WHERE account_id=" . issetGetValue('accountId') . " ORDER BY id DESC";
        $page               = issetGetValue('page');
        $limit              = 10;
        $offset             = ($page - 1) * $limit;
        $leaveApplications  = LeaveApplication::getAllPaginated($limit, $offset, $where);
        if($leaveApplications){
            foreach ($leaveApplications as $leaveApplication) {
                $leaveApplication->status();
            }
        }
        echo json_encode( $leaveApplications );
    } else if( isset($_GET['page'])) {
        $page               = issetGetValue('page');
        $limit              = 10;
        $offset             = ($page - 1) * $limit;
        $leaveApplications  = LeaveApplication::getAllPaginated($limit, $offset);
        foreach ($leaveApplications as $leaveApplication) {
            $status = file_get_contents("http://" . SERVICE_HOST . "/leave-application-api-capstone/ActionOnApplicationAPI.php?leave_application_id=" . $leaveApplication->id . "&status=true");
            $status = json_decode($status);
            $leaveApplication->status = $status;
        }
        echo json_encode( $leaveApplications );
    } else if ( isset($_GET['year']) && isset($_GET['month']) ){
        $year  = secureString($_GET['year']);
        $month = secureString($_GET['month']);

        echo json_encode( LeaveApplication::getAllByYearMonth( $year, $month ) );
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // INSERT
    $input = json_decode( file_get_contents("php://input") );
    if($input) {
        $successApplication = 1;

        $typeOfLeave = $input->type_of_leave;

        if($typeOfLeave == 'others') {
            $typeOfLeave = $input->others_reason;
        } else if ($typeOfLeave == 'vacation-others') {
            $typeOfLeave = 'Vacation - ' . $input->others_reason;
        }
        $accountID  = $input->account_id;
        $schoolID   = $input->school_id;

        $daysApplied    = $input->days_applied;
        if($typeOfLeave == 'Maternity') {
            $daysApplied = 60;
        }

        $dateFromYear   = $input->date_from_year;
        $dateFromMonth  = $input->date_from_month;
        $dateFromDay    = $input->date_from_day;

        $placeLeaveStay = $input->place;
        $placeLeaveStaySpecify = '';
        if($placeLeaveStay == 'within_philippines') {
            $placeLeaveStaySpecify = "Within Philippines";
        } else if($placeLeaveStay == 'abroad') {
            $placeLeaveStaySpecify = $input->abroad_specify;
        } else if($placeLeaveStay == 'in_hospital') {
            $placeLeaveStaySpecify = $input->in_hospital_specify;
        } else if($placeLeaveStay == 'out_patient') {
            $placeLeaveStaySpecify = $input->out_patient_specify;
        }

        $filename = '';
        if($input->attachment > '') { // check if there is a filename
            $filename = date("Y-m-d H-i-s") . " " . md5( rand()  ); // generate random string
            $imageFile = fopen("attachments/" . $filename  , "x");
            $fileContent = $input->fileDataURI;
            fwrite($imageFile, $fileContent);
            fclose($imageFile);
        }

        $commutationRequested = $input->commutation_requested;

        $leaveApplication    = new LeaveApplication();
        $leaveApplication->account_id       = $accountID;
        $leaveApplication->school_id        = $schoolID;
        $leaveApplication->date_filed       = date('Y-m-d');
        $leaveApplication->type_of_leave    = $typeOfLeave;
        $leaveApplication->number_days_applied = $daysApplied;
        $leaveApplication->from_date        = $dateFromYear . '-' . $dateFromMonth . '-' . $dateFromDay ;
        $leaveApplication->filename         = $filename;
        $leaveApplication->commutation_requested = $commutationRequested;
        $leaveApplication->place_stay       = $placeLeaveStay;
        $leaveApplication->place_stay_specify = $placeLeaveStaySpecify;

        $leaveApplication->save();

        echo json_encode( 1 );
    } else {
        echo json_encode( 0 );
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // UPDATE
//    parse_str(file_get_contents("php://input"), $post_vars);
//    echo $post_vars['id'];

    $input = json_decode(file_get_contents("php://input"));
    if(isset($input->id) && isset($input->cancel)) {
        $leaveApplication = LeaveApplication::get( $input->id );
        $leaveApplication->cancelled = $input->cancel;
        $leaveApplication->save();
        echo json_encode(1);
    } else {
        $leaveApplication = LeaveApplication::get( $input->id );
        if($leaveApplication->number_days_applied != $input->number_days_applied_edit) {
            $leaveApplication->number_days_applied = $input->number_days_applied_edit;
        }
        if($input->date_from_month_edit < 10) {
            $input->date_from_month_edit = '0' . $input->date_from_month_edit;
        }
        if($input->date_from_day_edit < 10) {
            $input->date_from_day_edit = '0' . $input->date_from_day_edit;
        }
        $date = $input->date_from_year_edit . '-' . $input->date_from_month_edit . '-' . $input->date_from_day_edit;
        $leaveApplication->from_date = $date;
        $leaveApplication->place_stay = "";
        $leaveApplication->place_stay_specify = $input->place_stay_specify_edit;
        $leaveApplication->commutation_requested = $input->commutation_requested_edit;

        $filename = '';
        if($input->attachment > '' && $leaveApplication->filename > ' ') {
            $leaveApplication->fileAttachment()->setContent($input->fileDataURI);
        } else if($input->attachment > '') {
            $filename = date("Y-m-d H-i-s") . " " . md5( rand()  ); // generate random string
            $imageFile = fopen("attachments/" . $filename  , "x");
            $fileContent = $input->fileDataURI;
            fwrite($imageFile, $fileContent);
            fclose($imageFile);
            $leaveApplication->filename = $filename;
        }

        $leaveApplication->save();

        echo json_encode($leaveApplication);
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // DELETE => use GET
    $leaveApplication = LeaveApplication::get(issetGetValue('id'));
    $leaveApplication->cancelled = 1;
    $leaveApplication->save();
}