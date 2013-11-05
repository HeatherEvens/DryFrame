<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Heather Evens
 * Date: 14/10/13
 * Time: 11:24
 * To change this template use File | Settings | File Templates.
 */
abstract class Controller
{
  /** @var  View        $view
   *  @var  DryFrame    $dry
   *  @var  Input       $input    */
  public $view;
  public $dry;
  public $input;
  public function __construct()
  {
    $allowed_origins = array('http://servicetec.com','http://www.servicetec.com','http://servicetec.co.uk','http://www.servicetec.co.uk','http://emstesting.co.uk');
    $http_origin = $_SERVER['HTTP_ORIGIN'];

    if (in_array($http_origin,$allowed_origins))
    {
      header("Access-Control-Allow-Origin: $http_origin");
    }
    $this->dry = DryFrame::getInstance();
    $this->input = Input::getInstance();
    $this->view = new View();
  }
  /**
   * @param string $method
   * @param array $arguments
   * @param DryFrame $dry
   */
  public function _remap($method,$arguments,$dry)
  {
    if (method_exists($this,$method))
      call_user_func_array(array($this,$method),$arguments);
    else
      $dry->show404();
  }

  public function load($library,$options = array())
  {
    $this->dry->load($library,$options);
    $this->$library = $this->dry->$library;
  }
}