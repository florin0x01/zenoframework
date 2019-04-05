<?php
namespace ZenoFramework\Routing;

class Router {
  const NS_CONTROLLERS = "ZenoFramework\\Controllers";
  const DUMMY_CONTROLLER = "ZenoFramework\\Controllers\\DummyController";
  private static $mappedUriToController = array();
  private static $registeredRoutes = array();
  private static $registeredControllers = array();

  public static function map(array $mapping) {
    static $alreadyMapped = false;
    if ($alreadyMapped) {
      return;
    }   
    $fqDummy = self::DUMMY_CONTROLLER;
    self::$registeredControllers[$fqDummy] = new $fqDummy();
    self::$registeredRoutes[$fqDummy] = array(
        'instance' => self::$registeredControllers[$fqDummy],
        'action' => 'none'
    );
    foreach($mapping as $uri=>$controller) {
      list ($ctrlName, $ctrlMethod) = self::getNameAndMethodFromCtrlName($controller);
      if (!array_key_exists($ctrlName, self::$registeredControllers)) {
        self::$registeredControllers[$ctrlName] = new $ctrlName();
      }
      self::$mappedUriToController[$uri] = $ctrlName;
      self::$registeredRoutes[$uri] = array(
        'instance' => self::$registeredControllers[$ctrlName],
        'action' => $ctrlMethod
      );
    }
    $alreadyMapped = true;
  }
  
  public static function serve() {
    list($uri, $action, $id) = self::parseURIActionAndParam($_SERVER['REQUEST_URI']);
    var_dump("serve <$uri> <$action> $id ");
    if (!array_key_exists($uri, self::$mappedUriToController)) {
      $controller = self::DUMMY_CONTROLLER; 
      $action = 'none';
      $id = -1;
    } else {
      $controller = self::$registeredRoutes[$uri]['instance'];
      $action = self::$registeredRoutes[$uri]['action'] ?? $action;
    }
    var_dump("Call with action $action");
    call_user_func(array($controller, $action), $id);
  }
  public static function getNameAndMethodFromCtrlName(string $controller) {
    $parts = explode("@", $controller);
    return [$parts[0], $parts[1]];
  }

  private static function parseURIActionAndParam(string $uri) {
    $action = 'none';
    $id = -1;

    $parts = explode("?", $uri);
    if (empty($parts[0]) || $parts[0] == "/index.php") {
      array_shift($parts);
      $uri = $parts[0];
    }
    $parts = explode("/", $parts[0]);
    var_dump($parts);

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
    $uri = preg_replace('/[0-9]+/', '{id}', $uri);
    return array($uri, $action, $id);
  }
} 