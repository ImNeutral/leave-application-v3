<?php
require_once ("DBQueries.php");
require_once ("Functions.php");

class LeaveApplication extends DBQueries {
    public static $table        = "leave_applications";
    public static $table_fields = array('id', 'account_id', 'office', 'school_id', 'date_filed', 'type_of_leave', 'number_days_applied',
                                        'place_stay', 'place_stay_specify', 'commutation_requested', 'from_date', 'filename', 'cancelled');

    public $id;
    public $account_id;
    public $office;
    public $school_id;
    public $date_filed;
    public $type_of_leave;
    public $number_days_applied;
    public $place_stay;
    public $place_stay_specify;
    public $filename;
    public $cancelled;
    public $commutation_requested;

    public static function submit($data) {
        $thisModel = new LeaveApplication();

        $thisModel->account_id              = $data['account_id'];
        $thisModel->office                  = $data['office'];
        $thisModel->school_id               = $data['school_id'];
        $thisModel->date_filed              = $data['date_filed'];
        $thisModel->type_of_leave           = $data['type_of_leave'];
        $thisModel->number_days_applied     = $data['number_days_applied'];

        return $thisModel;
//        return $thisModel->save();
    }

    public function pleaseDisregard() {
//        $typeOfLeave = issetPostValue('type_of_leave');
//
//        if($typeOfLeave == 'others') {
//            $typeOfLeave = issetPostValue('others_reason');
//        } else if ($typeOfLeave == 'vacation-others') {
//            $typeOfLeave = 'Vacation - ' . issetPostValue('others_reason');
//        }
//        $accountID  = $_SESSION['account_id'];
//        $schoolID   = $_SESSION['school_id'];
//
//        $daysApplied    = issetPostValue('days_applied');
//        if($typeOfLeave == 'Maternity') {
//            $daysApplied = 0;
//        }
//
//        $dateFromYear   = issetPostValue('date_from_year');
//        $dateFromMonth  = issetPostValue('date_from_month');
//        $dateFromDay    = issetPostValue('date_from_day');
//
//        $placeLeaveStay = issetPostValue('place');
//        $placeLeaveStaySpecify = '';
//        if($placeLeaveStay == 'within_philippines') {
//            $placeLeaveStaySpecify = "Within Philippines";
//        } else if($placeLeaveStay == 'abroad') {
//            $placeLeaveStaySpecify = issetPostValue('abroad_specify');
//        } else if($placeLeaveStay == 'in_hospital') {
//            $placeLeaveStaySpecify = issetPostValue('in_hospital_specify');
//        } else if($placeLeaveStay == 'out_patient') {
//            $placeLeaveStaySpecify = issetPostValue('out_patient_specify');
//        }
//
//        $commutationRequested = issetPostValue('commutation_requested');
//
//        $leaveApplication = new LeaveApplication();
//        $leaveApplication->account_id = $accountID;
//        $leaveApplication->school_id = $schoolID;
//        $leaveApplication->date_filed = date('Y-m-d');
//        $leaveApplication->type_of_leave = $typeOfLeave;
//        $leaveApplication->number_days_applied = $daysApplied;
//        $leaveApplication->from_date = $dateFromYear . '-' . $dateFromMonth . '-' . $dateFromDay;
//
//        $leaveApplication->save();
    }
}
