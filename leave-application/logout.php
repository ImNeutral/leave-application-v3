<?php
require_once ("services/Session.php");

$session = new Session();

$session->logout();

header('location: login.php');