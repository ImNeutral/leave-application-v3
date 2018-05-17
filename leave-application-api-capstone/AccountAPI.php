<?php
require_once ("Account.php");

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');


if(isset($_GET['username']) && isset($_GET['password']) ) {
    $username = $_GET['username'];
    $password = $_GET['password'];
    echo json_encode( Account::getByUsername($username, $password) );
}