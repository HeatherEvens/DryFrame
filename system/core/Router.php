<?php

class Router {
  private $requestedURI = array();
  private $_methodPos = 1;
  private $_argPos = 2;
  public static function getInstance()
  {
    static $inst = null;
    if ($inst === null) {
      $inst = new Router();
    }
    return $inst;
  }

  private function __construct() {
    $url = $_GET['path'];

    // we don't want the URL to start or end with /
    if (strpos($url,'/') === 0)
      $url = substr($url,1);
    if (strpos($url,'/') === strlen($url) - 1)
      $url = substr($url,0,-1);

    // split the url to its component parts, if length > 0
    if (strlen($url) > 0)
      $this->requestedURI = explode('/',$url);
    else
      $this->requestedURI = array();

    // our files and methods are camelCased, URLs should be hyphenated - adjust accordingly.
    foreach ($this->requestedURI as $key => $section)
    {
      $this->requestedURI[$key] = dashesToCamelCase($section);
    }

    // from the parts of the URL, find the correct controller, method, and arguments
    $this->requestedController = $this->findController();
    $this->requestedMethod = $this->findMethod();
    $this->requestArguments = $this->findArguments();
  }

  public function findController() {
    // figure out how much of the requested path points to a controller
    // note that controllers may exist in subfolders
    // we'll walk backwards from the end of the array checking if the paths exist
    $i = count($this->requestedURI) - 1;
    // if $i=-1, the path has no parts so we use default controller
    if ($i === -1)
    {
      include SYSTEM_PATH.'/controller/'.DEFAULT_CONTROLLER.'.php';
        // ucfirst because filenames are like camelCase but class names like CamelCase
      return ucfirst(DEFAULT_CONTROLLER);
    }
    
    $tempArr = $this->requestedURI;
    while ($i >= 0)
    {
      // check if the controller for the current position in the array exists
      $controllerPath = SYSTEM_PATH.'/controller/'.implode('/',$tempArr).'.php';
      if (file_exists($controllerPath))
      {
        include $controllerPath;
        // position of the method in the array is current position + 1
        $this->_methodPos = $i + 1;
        // ucfirst because filenames are like camelCase but class names like CamelCase
        return ucfirst($tempArr[$i]);
      }
      // didn't find it at this position, pop the item off the end of the array and try again
      array_pop($tempArr);
      $i--;
    }
  }

  public function findMethod() {
    // the position of the first argument is method position + 1
    $this->_argPos = $this->_methodPos + 1;
    // if no method specified, defaults to index()
    if ($this->_methodPos >= count($this->requestedURI))
      return 'index';

    return $this->requestedURI[$this->_methodPos];
  }

  public function findArguments() {
    if ($this->_argPos >= count($this->requestedURI))
      return array();
    $i = $this->_argPos;
    // build a new array containing the elements of the array which are arguments
    // (so original array is preserved)
    $tempArr = array();
    while ($i < count($this->requestedURI))
    {
      $tempArr[] = $this->requestedURI[$i];
      $i++;
    }
    return $tempArr;
  }

  /**
   * @param DryFrame $dry
   */
  public function route($dry) {
    /** @var Controller $controller */
    $controller = new $this->requestedController();
    // set the controller for this instance
    $dry->setController($controller);
    $method = $this->requestedMethod;
    // call _remap on the controller, passing it the method and arguments, and injecting
    // this instance of DRY.
    $controller->_remap($method,$this->requestArguments,$dry);
    $controller->view->displayTemplate();
  }
}
