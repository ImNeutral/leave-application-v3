<?php
require_once ("DBQueries.php");
require_once ("Employee.php");

class School extends DBQueries {
    public static $table        = "schools";
    public static $table_fields = array('id', 'school_name', 'school_type');

    public $id;
    public $school_name;
    public $school_type;

//    public function Employees($page, $limit = 10) {
//        $offset     = ($page - 1) * $limit;
//        $where      = " WHERE school_id=" . $this->id;
//        $employees   = Employee::getAllPaginated($limit, $offset, $where);
//        return $employees;
//    }

    public function Employees() {
        $where      = " WHERE school_id=" . $this->id;
        $employees  = Employee::getAll($where);
        return $employees;
    }
}