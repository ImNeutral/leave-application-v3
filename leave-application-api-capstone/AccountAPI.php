<?php
require_once ("Account.php");
require_once ("Functions.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // FETCH
    if( isset($_GET['username']) && isset($_GET['password']) ) {
        $username = $_GET['username'];
        $password = $_GET['password'];
        echo json_encode( Account::getByUsername($username, $password) );
    } else if( isset($_GET['account_id']) && isset($_GET['owner']) ) {
        $account = Account::get($_GET['account_id']);
        echo json_encode($account->owner());
    } else if(isset($_GET['school_id']) && isset($_GET['employees']) ) {
        $url        = "http://" . SERVICE_HOST . "/leave-application-api-deped/SchoolAPI.php?";
        $url        .= "school_id="    . $_GET['school_id'];
        $url        .= "&employees=true";

        $employees  = file_get_contents( $url );
        $employees  = json_decode($employees);

        $employeeAccounts    = [];
        $sortable            = [];
        foreach ($employees as $employee) {
            $accounts = Account::getByEmployeeId($employee->id);
            foreach ($accounts as $account) {
                $employeeAccountInstance = array(
                    'employee_id'       => $employee->id,
                    'fullname'          => ucwords(strtolower( $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name )),
                    'account_id'        => $account['id'],
                    'username'          => $account['username'],
                    'account_type_id'   => $account['account_type_id']
                );
                array_push($employeeAccounts, $employeeAccountInstance);
                array_push($sortable, $employee->first_name);
            }
        }
        array_multisort($sortable, SORT_ASC, $employeeAccounts);
        echo json_encode($employeeAccounts);
    } else if(isset($_GET['username']) && isset($_GET['search'])) {
        $accounts = Account::searchByUsername($_GET['username']);
        $employeeAccounts    = [];

        foreach ($accounts as $account) {
            $employeeAccountInstance = array(
                'employee_id'       => $account[0]['employee_id'],
                'fullname'          => $account[1],
                'account_id'        => $account[0]['id'],
                'username'          => $account[0]['username'],
                'account_type_id'   => $account[0]['account_type_id']
            );
            array_push($employeeAccounts, $employeeAccountInstance);
        }
        echo json_encode($employeeAccounts);
    } else if( isset($_GET['username']) && isset($_GET['fixed_search']) ) {
        echo json_encode( Account::isUsernameExist($_GET['username']) );
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Create
    $input = json_decode(file_get_contents("php://input"));
    if(isset($input->employee_id) && isset($input->account_type_id) && isset($input->username) && isset($input->password) ) {
        $account = new Account();
        $account->employee_id       = $input->employee_id;
        $account->account_type_id   = $input->account_type_id;
        $account->username          = secureString($input->username);
        $account->password          = $input->password;
        $account->password          = $account->getPassword();
        $account->save();
        echo json_encode(1);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // FETCH
    $input = json_decode(file_get_contents("php://input"));
    if(isset($input->username) && isset($input->old_password)) {
        $username   = $input->username;
        $password   = $input->old_password;
        $account    = Account::getByUsername($username, $password);
        if($account) {
            $account    = Account::get($account[0]['id']);
            $account->password = $account->encryptPassword( $input->new_password );
            $account->save();
            echo json_encode('1');
        } else {
            echo json_encode('0');
        }
    } else if( isset($input->account_id) && isset($input->account_type_id)) {
        $account        = Account::get($input->account_id);
        $account->account_type_id = $input->account_type_id;
        if( isset($input->password) ) {
            $account->password      = $account->encryptPassword( $input->password );
        }
        $account->save();
        echo json_encode('1');
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // FETCH

}