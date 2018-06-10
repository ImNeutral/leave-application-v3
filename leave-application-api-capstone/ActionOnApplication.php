<?php
require_once ("DBQueries.php");
require_once ("Functions.php");
require_once ("CertificationOfLeaveCredits.php");
require_once ("OSDSAction.php");
require_once ("Recommendation.php");

class ActionOnApplication extends DBQueries {
    public static $table        = "action_on_applications";
    public static $table_fields = array('id', 'leave_application_id', 'school_head_approved', 'hr_approved', 'division_head_approved');

    public $id;
    public $leave_application_id;
    public $school_head_approved;
    public $hr_approved;
    public $division_head_approved;

    public static function getByLeaveApplicationId($id) {
        $id = self::escapeValue($id);
        $sql = " SELECT id FROM " . self::$table;
        $sql .= " WHERE leave_application_id='" . $id . "' LIMIT 1";

        $result  = self::getByQuery($sql);
        $action = $result->fetch_assoc();

        return self::get($action['id']);
    }

    public function getStatus() {
        if ($this->school_head_approved && $this->hr_approved && $this->division_head_approved) {
            return 'Accepted';
        } else if($this->school_head_approved == null && $this->hr_approved ==  null && $this->division_head_approved == null) {
            return 'In: Principal';
        } else if ($this->school_head_approved == 1 && $this->hr_approved ==  null && $this->division_head_approved == null) {
            return 'In: HR';
        } else if ($this->school_head_approved == 1 && $this->hr_approved == 1 && $this->division_head_approved == null) {
            return 'In: SDS';
        } else {
            return 'Rejected';
        }
    }

    public function CertificationOfLeaveCredits() {
        return CertificationOfLeaveCredits::getByActionOnApplicationsId($this->id);
    }

    public function OSDSAction() {
        return OSDSAction::getByActionOnApplicationsId($this->id);
    }

    public function Recommendation() {
        return Recommendation::getByActionOnApplicationsId($this->id);
    }
}
