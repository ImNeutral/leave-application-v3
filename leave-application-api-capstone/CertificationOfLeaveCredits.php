<?php
require_once ("DBQueries.php");
require_once ("Functions.php");

class CertificationOfLeaveCredits extends DBQueries {
    public static $table        = "certification_of_leave_credits";
    public static $table_fields = array('id', 'action_on_applications_id', 'as_of', 'remaining_days', 'vacation_days',
                                    'sick_days', 'total', 'approved_for');

    public $id;
    public $action_on_applications_id;
    public $as_of;
    public $remaining_days;
    public $vacation_days;
    public $sick_days;
    public $total;
    public $approved_for;

    public static function getByActionOnApplicationsId($id) {
        $id = self::escapeValue($id);
        $sql = " SELECT id FROM " . self::$table;
        $sql .= " WHERE action_on_applications_id='" . $id . "' LIMIT 1";

        $result  = self::getByQuery($sql);
        $certificationOfLeaveCredits = $result->fetch_assoc();

        return self::get($certificationOfLeaveCredits['id']);
    }
}
