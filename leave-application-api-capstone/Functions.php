<?php

function issetGetValue($getName) {
    $val = isset($_GET[$getName]) ? $_GET[$getName] : '';
    return escapeValue($val);
}

function issetPostValue($postName) {
    $val = isset($_POST[$postName]) ? $_POST[$postName] : '';
    return escapeValue($val);
}

function replaceSpaces($var) {
    return str_replace(' ', '%20', $var);
}

function escapeValue($val) {
    return addslashes(strip_tags( $val ));
}

function secureString($str) {
    return addslashes( strip_tags($str) );
}


