<?php
require_once ("Connection.php");

class DBQueries {

//    public static function getAll() {
//        $sql        = "SELECT " . self::tableFieldsString() . " FROM " . static::$table;
//        $results    = self::query($sql);
//        $return     = array();
//        foreach ($results as $result) {
//            $return[] = $result;
//        }
//        return $return;
//    }

    public static function getAll() {
        $sql        = "SELECT " . self::tableFieldsString() . " FROM " . static::$table;
        $results    = self::query($sql);
        $return     = array();
        $object     = get_called_class();
        foreach ($results as $result) {
            $objectInstance = new $object;
            foreach ($object::$table_fields as $field) {
                $objectInstance->$field = utf8_encode($result[$field]);
            }
            $return[] = $objectInstance;
        }
        return $return;
    }


    public static function getAllPaginated($limit = 10, $offset = 0, $where = '') {
        $sql        = "SELECT " . self::tableFieldsString() . " FROM " . static::$table;
        $sql        .= " " . $where;
        $sql        .= " LIMIT " . $limit . " OFFSET " . $offset;
        $results    = self::query($sql);
        $return     = array();
        $object     = get_called_class();
        if($results) {
            foreach ($results as $result) {
                $objectInstance = new $object;
                foreach ($object::$table_fields as $field) {
                    $objectInstance->$field = utf8_encode($result[$field]);
                }
                $return[] = $objectInstance;
            }
        }
        return $return;
    }


    public static function getById($id) {
        $id         = self::escapeValue($id);
        $sql        = "SELECT " . self::tableFieldsString() . " FROM " . static::$table . " ";
        $sql        .= "WHERE id=" . $id;
        return self::query($sql)->fetch_assoc();
    }

    public static function getByQuery($sql = "") {
        $sql    = self::escapeValue($sql);
        $result = run()->query( $sql);
        return $result;
    }

    private static function query($sql = "") {
        $result = run()->query( $sql);
        return $result;
    }

    public static function tableFieldsString() {
        return join(', ', static::$table_fields);
    }

    public static function escapeValue($val) {
        return strip_tags( stripslashes($val) );
    }


    public function getTable() {
        $class = get_called_class();
        $tableName = $class::$table;
        return $tableName;
    }

    public function getTableFields() {
        $class = get_called_class();
        $tableFields = $class::$table_fields;
        return $tableFields;

    }

    public static function count() {
        $sql = "SELECT count(id) FROM " . static::$table;
        $result  = self::getByQuery($sql);
        $result = $result->fetch_assoc();
        return $result;
    }


    public static function get($id) {
        $result = self::getById($id);
        $class = get_called_class();
        $class = new $class;
        foreach (static::$table_fields as $field) {
            $class->$field = utf8_encode($result[$field]);
        }
        return $class;
    }

    public function save() {
            return isset($this->id)? $this->update() :$this->insert();
    }

    public function update() {
        $sql  = "UPDATE " . $this->getTable() . " SET ";
        $counter = 0;
        foreach ($this->getTableFields() as $field) {
            if($field != "id") {
                if($counter++) {
                    $sql .= ", ";
                }
                $sql .= $field . "='" . $this->$field . "' ";
            }

        }
        $sql .= " WHERE id=" . $this->id;

        if(self::getByQuery($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function insert() {
        $sql = "INSERT INTO " . $this->getTable();
        $sql .= " (" . self::tableFieldsString() . ") ";
        $sql .= " VALUES (";
        $fieldValues = array();
        foreach ($this->getTableFields() as $field) {
            array_push($fieldValues, "'" . $this->$field . "'");
        }
        $sql .= join(",", $fieldValues);
        $sql .= " ) ";

        if(self::getByQuery($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function delete($id) {
        $sql = "DELETE FROM " . static::$table;
        $sql .= " WHERE id=" . $id;

        if(self::getByQuery($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

}