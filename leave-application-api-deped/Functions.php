<?php

function issetGetValue($getName) {
    return isset($_GET[$getName]) ? $_GET[$getName] : '';
}

function issetPostValue($postName) {
    return isset($_POST[$postName]) ? $_POST[$postName] : '';
}

function replaceSpaces($var) {
    return str_replace(' ', '%20', $var);
}

