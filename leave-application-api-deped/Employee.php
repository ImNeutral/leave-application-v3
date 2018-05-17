<?php
require_once ("DBQueries.php");

class Employee extends DBQueries {
    public static $table        = "employees";
    public static $table_fields = array('id', 'school_id', 'first_name', 'middle_name', 'last_name' );

    public $id;
    public $school_id;
    public $first_name;
    public $middle_name;
    public $last_name;

    public static function searchByName ($firstName, $lastName) {
        $firstName = self::escapeValue($firstName);
        $lastName = self::escapeValue($lastName);
        $sql        = "SELECT " . self::tableFieldsString() . " FROM " . static::$table;
        $sql        .= " WHERE first_name='" . $firstName . "' AND last_name='" . $lastName . "'";

        $result  = self::getByQuery($sql);
        $result = $result->fetch_assoc();
        return $result;
    }
}