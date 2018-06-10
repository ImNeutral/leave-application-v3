<?php
require_once ("DBQueries.php");
require_once ("Functions.php");

class OSDSAction extends DBQueries {
    public static $table        = "osds_action";
    public static $table_fields = array('id', 'action_on_applications_id', 'as_of', 'days_with_pay', 'days_without_pay',
                                    'others_days', 'others_description', 'disapproved_due_to');

    public $id;
    public $action_on_applications_id;
    public $as_of;
    public $days_with_pay;
    public $days_without_pay;
    public $others_days;
    public $others_description;
    public $disapproved_due_to;

    public static function getByActionOnApplicationsId($id) {
        $id = self::escapeValue($id);
        $sql = " SELECT id FROM " . self::$table;
        $sql .= " WHERE action_on_applications_id='" . $id . "' LIMIT 1";

        $result  = self::getByQuery($sql);
        $OSDSAction = $result->fetch_assoc();

        return self::get($OSDSAction['id']);
    }
}
