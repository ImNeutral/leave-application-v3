<?php
require_once ("DBQueries.php");
require_once ("FileAttachment.php");

class Account extends DBQueries {
    public static $table        = "accounts";
    public static $table_fields = array('id', 'account_type_id', 'employee_id', 'username', 'password', 'profile_picture');

    public $id;
    public $account_type_id;
    public $employee_id;
    public $username;
    public $password;
    public $profile_picture;

    public static function getByUsername($username, $password) {
        $username = self::secureString($username);
        $sql = " SELECT * FROM " . self::$table;
        $sql .= " WHERE username='" . $username . "' LIMIT 1";

        $result  = self::getByQuery($sql);
        $account = $result->fetch_assoc();
        if($result->num_rows <= 0) {
            return false;
        } else {
            if (md5($password) == $account['password']) {
                $employee_id = $account['employee_id'];

                $employee_data = file_get_contents('http://' . SERVICE_HOST_2 . '/leave-application-api-deped/EmployeeAPI.php?id=' . $employee_id);
                $employee_data = json_decode($employee_data);

                $accountData = [$account, $employee_data];
//                $_SESSION['account_id'] = $account['id'];
//                $_SESSION['full_name'] = ucwords(strtolower( $employee_data->first_name . ' ' . $employee_data->middle_name . ' ' . $employee_data->last_name ));
//                $_SESSION['username'] = $username;
//                $_SESSION['account_type_id'] = $account['account_type_id'];
//                $_SESSION['employee_id']     = $employee_id;
//                $_SESSION['school_id']      = $employee_data->school_id;
                return $accountData;
            } else {
                return false;
            }
        }
    }

    public static function searchByUsername($username) {
        $username = self::secureString($username);
        $sql = " SELECT * FROM " . self::$table;
        $sql .= " WHERE username LIKE '%" . $username . "%' ORDER BY username";
        $results = array();
        foreach (Account::getByQuery($sql) as $account) {
            $results[] = [$account, Account::accountOwner($account['employee_id'])];
        }
        return $results;
    }

    public static function getByEmployeeId($employee_id) {
        $sql = "SELECT * FROM " . self::$table;
        $sql .= " WHERE employee_id=" . $employee_id;
        $results = array();
        foreach (Account::getByQuery($sql) as $account) {
            $results[] = $account;
        }
        return $results;
    }

    public static function isUsernameExist($username) {
        $username = DBQueries::escapeValue($username);
        $sql = " SELECT * FROM " . self::$table;
        $sql .= " WHERE username='" . $username . "' LIMIT 1";

        $result = self::getByQuery($sql);
        return $result->num_rows;
    }

    public static function accountOwner($employee_id) {
        $employee_data  = file_get_contents('http://' . SERVICE_HOST_2 . '/leave-application-api-deped/EmployeeAPI.php?id=' . $employee_id);
        $employee_data  = json_decode($employee_data);
        return ucwords(strtolower( $employee_data->first_name . ' ' . $employee_data->middle_name . ' ' . $employee_data->last_name ));
    }

    public function owner() {
        return json_decode(file_get_contents('http://' . SERVICE_HOST_2 . '/leave-application-api-deped/EmployeeAPI.php?id=' . $this->employee_id . '&school=true'));
    }

    public function getPassword() {
        return $this->encryptPassword($this->password);
    }

    public function encryptPassword($password) {
        return md5($password);
    }

//    public function save() {
//        $sql = "INSERT INTO " . self::$table;
//        $sql .= " (" . self::tableFieldsString() . ") ";
//        $sql .= "VALUES ( ";
//        $sql .= "null, ";
//        $sql .= $this->account_type_id . ", ";
//        $sql .= $this->employee_id     . ", '";
//        $sql .= self::escapeValue($this->username) . "', '";
//        $sql .= $this->getPassword() . "' ";
//        $sql .= " ) ";
//
//        if(self::getByQuery($sql)) {
//            return 1;
//        } else {
//            return 0;
//        }
//    }

//    public function update() {
//        $sql = "UPDATE " . self::$table;
//        $sql .= " SET password='" . $this->getPassword() . "' ";
//        $sql .= ", account_type_id=" . $this->account_type_id;
//        $sql .= " WHERE id=" . $this->id;
//
//        if(self::getByQuery($sql)) {
//            return 1;
//        } else {
//            return 0;
//        }
//    }

    public function updatePassword() {
        $sql = "UPDATE " . self::$table;
        $sql .= " SET password='" . $this->getPassword() . "' ";
        $sql .= " WHERE id=" . $this->id;

        if(self::getByQuery($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function updateAccountType() {
        $sql = "UPDATE " . self::$table;
        $sql .= " SET account_type_id=" . $this->account_type_id;
        $sql .= " WHERE id=" . $this->id;

        if(self::getByQuery($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getProfilePicture() {
        $fileName = $this->profile_picture;
        $file = new FileAttachment($fileName);
        echo json_encode($file->getContent());
    }
}