<?php
require_once ("DBQueries.php");

class School extends DBQueries {
    public static $table        = "schools";
    public static $table_fields = array('id', 'school_name', 'school_type');

    public $id;
    public $school_name;
    public $school_type;

}