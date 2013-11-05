<?php

class DryFrame {
  /**
   * @var $controller Controller
   * @var $router Router
   * @var $input Input
   */
  protected $controller;
  protected $router;
  protected $input;
  private $classes = array();
  public static function getInstance()
  {
    static $inst = null;
    if ($inst === null) {
      $inst = new DryFrame();
    }
    return $inst;
  }

  private function __construct() {
    include_once SYSTEM_PATH.'/libraries/stringFunctions.php';
    $this->router = Router::getInstance();
  }

  public function go() {
    $this->router->route($this);
  }

  /**
   * @param string $controller
   */
  public function setController($controller)
  {
    $this->controller = $controller;
  }

  /**
   * @param string $customMsg
   */
  public function show404($customMsg = '')
  {
    // @TODO: 404 handling
  }

  /**
   * Load a class if not loaded
   * 
   * @param string $class Name of the class to load
   * @param array $options Array of options to send to the class on init
   **/
  public function load($class,$options = array())
  {
    if (!in_array($class,$this->classes))
    {
      $className = ucfirst($class);
      // possible paths where we might find the requested class
      $paths = array(
        SYSTEM_PATH.'/libraries/'.$className.'/'.$className.'.php',
        SYSTEM_PATH.'/model/'.$className.'.php',
      );
      $loaded = false;
      foreach ($paths as $path)
      {
        if (file_exists($path))
        {
          // if file exists, include it
          include_once($path);
          $loaded = true;
          break;
        }
      }
      if ($loaded)
      {
        // if class was found, create new instance
        $this->classes[] = $class;
        if (count($options) > 0)
        {
          $this->$class = new $className($options);
        }
        else
        {
          $this->$class = new $className();
        }
      }
      // @TODO: error handling for class not found
    }
  }
}
