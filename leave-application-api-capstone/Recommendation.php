<?php
require_once ("DBQueries.php");
require_once ("Functions.php");

class Recommendation extends DBQueries {
    public static $table        = "recommendation";
    public static $table_fields = array('id', 'action_on_applications_id', 'as_of', 'disapproval_due_to', 'recommendation');

    public $id;
    public $action_on_applications_id;
    public $as_of;
    public $disapproval_due_to;
    public $recommendation;

    public static function getByActionOnApplicationsId($id) {
        $id = self::escapeValue($id);
        $sql = " SELECT id FROM " . self::$table;
        $sql .= " WHERE action_on_applications_id='" . $id . "' LIMIT 1";
        $result  = self::getByQuery($sql);
        $recommendation = $result->fetch_assoc();
        return self::get($recommendation['id']);
    }
}
