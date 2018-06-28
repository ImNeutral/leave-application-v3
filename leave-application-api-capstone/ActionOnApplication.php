<?php
require_once ("DBQueries.php");
require_once ("Functions.php");
require_once ("CertificationOfLeaveCredits.php");
require_once ("OSDSAction.php");
require_once ("Recommendation.php");
require_once ("LeaveApplication.php");

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

    public function manualUpdate($col, $val) {
        $val = self::escapeValue($val);
        $sql = "UPDATE action_on_applications SET " . $col . "=". $val . " WHERE id=" . $this->id;
        self::getByQuery($sql);
    }

    public function getStatus() {
        $status = "";
        if ($this->school_head_approved && $this->hr_approved && $this->division_head_approved) {
            $status = 'Accepted';
        } else if($this->school_head_approved == null && $this->hr_approved ==  null && $this->division_head_approved == null) {
            $status = 'In: Principal';
        } else if ($this->school_head_approved == 1 && $this->hr_approved ==  null && $this->division_head_approved == null) {
            $status = 'In: HR';
        } else if ($this->school_head_approved == 1 && $this->hr_approved == 1 && $this->division_head_approved == null) {
            $status = 'In: SDS';
        } else {
            $status = 'Rejected';
        }
        return $status;
    }

    public static function leaveApplications($adminTypeId, $status, $page) {
        $limit              = 10;
        $offset             = ($page - 1) * $limit;
        $where              = " WHERE id IN (SELECT leave_application_id as id FROM action_on_applications ";
        if($adminTypeId == 2) {
            $where .= self::principalWhere($status);
        } else if($adminTypeId == 3) {
            $where .= self::hrWhere($status);
        } else if($adminTypeId == 4) {
            $where .= self::sdsWhere($status);
        }
        $where              .= " ) ORDER BY id DESC";
        return LeaveApplication::getAllPaginated($limit, $offset, $where);
    }

    public static function principalCount($status) {
        return ActionOnApplication::count(self::principalWhere($status));
    }

    public static function hrCount($status) {
        return ActionOnApplication::count(self::hrWhere($status));
    }

    public static function sdsCount($status) {
        return ActionOnApplication::count(self::sdsWhere($status));
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

    public static function sdsWhere($status) {
        $where = " WHERE school_head_approved = 1 AND ";
        $where .= " hr_approved = 1 AND ";
        if($status == '0' || $status == '1') {
            $where .= " division_head_approved = " . $status;
        } else {
            $where .= " division_head_approved IS " . $status;
        }
        return $where;
    }

    public static function hrWhere($status) {
        $where = " WHERE school_head_approved = 1 AND ";
        if($status == '0' || $status == '1') {
            $where .= " hr_approved = " . $status;
        } else {
            $where .= " hr_approved IS " . $status;
        }
        return $where;
    }

    public static function principalWhere($status) {
        $where = " WHERE ";
        if($status == '0' || $status == '1') {
            $where .= " school_head_approved = " . $status;
        } else {
            $where .= " school_head_approved IS " . $status;
        }
        return $where;
    }
}
