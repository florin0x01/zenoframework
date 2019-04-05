<?php
namespace ZenoFramework\Routing;

class Router {
  const NS_CONTROLLERS = "ZenoFramework\\Controllers";
  const DUMMY_CONTROLLER = "ZenoFramework\\Controllers\\DummyController";
  private static $mappedUriToController = array();
  private static $registeredControllers = array();

  public static function map(array $mapping) {
    static $alreadyMapped = false;
    if ($alreadyMapped) {
      return;
    }   
    $fqDummy = self::DUMMY_CONTROLLER;
    self::$registeredControllers["DummyController"] = new $fqDummy();
    foreach($mapping as $uri=>$controller) {
      self::$mappedUriToController[$uri] = $controller;
      list ($ns, ) = self::getNSAndNameFromCtrlName($controller);
      self::$registeredControllers[$controller] = new $controller();
    }
    $alreadyMapped = true;
  }
  
  public static function serve() {
    list($uri, $action, $id) = self::getControllerActionAndId($_SERVER['REQUEST_URI']);
    if (!array_key_exists($uri, self::$mappedUriToController)) {
      $controller = self::DUMMY_CONTROLLER; 
      $action = 'none';
      $id = -1;
    } else {
      $controller = self::$registeredControllers[self::$mappedUriToController[$uri]];
    }
    call_user_func(array($controller, $action), $id);
  }
  private static function getNSAndNameFromCtrlName(string $controller) {
    $parts = explode("\\", $controller);
    $ctrlName = $parts[count($parts)-1];
    array_splice($parts, 0,count($parts)-1);
    var_dump($ctrlName);
    $ns = implode("\\", $parts);
    return [$ns, $ctrlName];
  }

  private static function getControllerActionAndId(string $uri) {
    $controller = self::DUMMY_CONTROLLER; 
    $action = 'none';
    $id = -1;

    $parts = explode("?", $uri);
    if (empty($parts[0]) || $parts[0] == "/index.php") {
      array_shift($parts);
    }
    $controller = $parts[0];

    switch(count($parts)) {
      case 1: 
        {
          $action = 'index';
        }
        break;
      case 2:
        {
          if (is_numeric($parts[1])) {
            $action = 'none';
            $id = $parts[1];  
          } else {
            $action = $parts[1];
          }
        }
        break;
      case 3:
        {
          $id = $parts[1];
          $action = $parts[2];
        }
        break;
    } 
    return array($controller, $action, $id);
  }
} 