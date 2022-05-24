<?php
class Session
{
  public static function startSession()
  {
    session_start();
  }
  public static function setValue($key, $value)
  {
    $_SESSION[$key] = $value;
  }
  public static function getValue($key)
  {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }
  }
  public static function freeSession()
  {
    $_SESSION = array();
    session_destroy();
  }
}