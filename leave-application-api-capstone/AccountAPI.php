<?php
require_once ("Account.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // FETCH
    if(isset($_GET['username']) && isset($_GET['password']) ) {
        $username = $_GET['username'];
        $password = $_GET['password'];
        echo json_encode( Account::getByUsername($username, $password) );
    } else if(isset($_GET['account_id']) && isset($_GET['owner'])) {
        $account = Account::get($_GET['account_id']);
        echo json_encode($account->owner());
    }

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // FETCH

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
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // FETCH

}