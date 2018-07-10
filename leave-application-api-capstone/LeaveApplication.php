<?php
require_once ("DBQueries.php");
require_once ("Functions.php");
require_once ("FileAttachment.php");
require_once ("Account.php");

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
    public $status;

    public static function submit($data) {
        $thisModel = new LeaveApplication();

        $thisModel->account_id              = $data['account_id'];
        $thisModel->office                  = $data['office'];
        $thisModel->school_id               = $data['school_id'];
        $thisModel->date_filed              = $data['date_filed'];
        $thisModel->type_of_leave           = $data['type_of_leave'];
        $thisModel->number_days_applied     = $data['number_days_applied'];

        return $thisModel;
    }

    public function status() {
        $status = file_get_contents("http://" . SERVICE_HOST . "/leave-application-api-capstone/ActionOnApplicationAPI.php?leave_application_id=" . $this->id . "&status=true");
        $status = json_decode($status);
        if($this->cancelled) {
            $status = "Cancelled";
        }
        $this->status = $status;
    }

    public function fileAttachment() {
        return (new FileAttachment($this->filename));
    }

    public function getOwner() {
        $account    = Account::get($this->account_id);
        return $account->accountOwner($account->employee_id);
    }

    public static function getAllByYearMonth($year, $month) {
        $where  = " WHERE id IN (SELECT leave_application_id FROM `action_on_applications` WHERE division_head_approved=1) ";
        $where .= " AND EXTRACT(MONTH FROM from_date) = " . $month;
        $where .= " AND EXTRACT(YEAR FROM from_date) = " . $year;
        $where .= " AND cancelled = 0 ORDER BY from_date ASC";

        $leaveApplications       = LeaveApplication::getAll($where);
        $leaveApplicationsList   = [];
        $employeeApplication     = [];

        foreach ($leaveApplications as $leaveApplication) {
            $employeeApplication['id']                      = $leaveApplication->id;
            $employeeApplication['date_filed']              = $leaveApplication->date_filed;
            $employeeApplication['type_of_leave']           = $leaveApplication->type_of_leave;
            $employeeApplication['number_days_applied']     = $leaveApplication->number_days_applied;
            $employeeApplication['commutation_requested']   = $leaveApplication->commutation_requested;
            $employeeApplication['from_date']               = $leaveApplication->from_date;
            $employeeApplication['applicant_name']          = $leaveApplication->getOwner();

            array_push($leaveApplicationsList, $employeeApplication);
        }
        return $leaveApplicationsList;
    }
}