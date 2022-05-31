<?php
class Session
{
    public static function startSession()
    {
        session_start();
    }
    public static function setValue($var, $value)
    {
        $_SESSION[$var] = $value;
    }
        public static function getValue($var)
    {
        if (isset($_SESSION[$var])) {
            return $_SESSION[$var];
        }
    }
    public static function freeSession()
    {
        $_SESSION = array();
        session_destroy();
    }
}