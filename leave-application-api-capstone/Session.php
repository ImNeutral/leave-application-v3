<?php

class Session {
    public static function isLoggedIn() {
        if(isset($_SESSION['username'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function get($key) {
        return $_SESSION[$key];
    }

    public static function set($key, $val) {
        $_SESSION[$key] = $val;
    }

    public function logout() {
        session_unset();
    }
}