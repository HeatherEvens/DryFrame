<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Heather Evens
 * Date: 14/10/13
 * Time: 14:33
 * To change this template use File | Settings | File Templates.
 */

class Input {
  public static function getInstance()
  {
    static $inst = null;
    if ($inst === null) {
      $inst = new Input();
    }
    return $inst;
  }

  private function __construct() {

  }
  public function parse($inputName, $default)
  {
    $input = INPUT_COOKIE;
    if (isset($_POST[$inputName]))
      $input = INPUT_POST;
    elseif (isset($_GET[$inputName]))
      $input = INPUT_GET;
    elseif (isset($_SESSION[$inputName]))
      $input = INPUT_SESSION;
    elseif (!isset($_COOKIE[$inputName]))
    {
      // if we get to this statement, POST, GET, SESSION and COOKIE are not set for this var, return default
      return $default;
    }
    $type = gettype($default);
    switch($type)
    {
      case 'boolean':
        return filter_input($input,$inputName,FILTER_VALIDATE_BOOLEAN);
      case 'integer':
        return filter_input($input,$inputName,FILTER_VALIDATE_INT);
      case 'double':
        return filter_input($input,$inputName,FILTER_VALIDATE_FLOAT);
      case 'string':
        return trim(filter_input($input,$inputName,FILTER_UNSAFE_RAW));
      case 'array':
        return $this->_filter_array($input,$inputName);
      default:
        return $default;
    }
  }

  private function _filter_array($input,$inputName)
  {
    // get the input array
    switch($input)
    {
      case INPUT_POST:
        $inputArr = $_POST[$inputName];
        break;
      case INPUT_GET:
        $inputArr = $_GET[$inputName];
        break;
      case INPUT_SESSION:
        $inputArr = $_SESSION[$inputName];
        break;
      default:
        $inputArr = $_COOKIE[$inputName];
        break;
    }

    // we need to return it as an array as that is what was asked for
    if (!is_array($inputArr))
    {
      $temp = $inputArr;
      $inputArr = array();
      $inputArr[] = $temp;
    }

    return $inputArr;
  }
}