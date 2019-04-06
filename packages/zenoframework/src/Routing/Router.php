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
      list ($ctrlName, $ctrlAction, $ctrlMethods) = self::getNameActionAndMethodFromControllerName($controller);
      var_dump("OOO $ctrlMethods");
      foreach($ctrlMethods as $k=>$ctrlMethod) {
        echo "Got $ctrlMethod $ctrlAction for $uri <br />";
        if (!array_key_exists($ctrlName, self::$registeredControllers)) {
          self::$registeredControllers[$ctrlName] = new $ctrlName();
        }
        self::$mappedUriToController[$uri] = $ctrlName;
        echo "REG with $ctrlMethod for $uri <br />";
        self::$registeredRoutes[$uri][$ctrlMethod] = array(
          'instance' => self::$registeredControllers[$ctrlName],
          'action' => $ctrlAction
        );
      }
    }
    $alreadyMapped = true;
  }
  
  public static function serve() {
    list($uri, $action, $id) = self::parseURIActionAndParam($_SERVER['REQUEST_URI']);
    echo "<br /> Route $uri $action $id <br />";
    if (!array_key_exists($uri, self::$mappedUriToController)) {
      echo "NPOT FOUND $uri <br />";
      $controller = self::$registeredControllers[self::DUMMY_CONTROLLER]; 
      $action = 'none';
      $id = -1;
    } else {
      $controller = self::$registeredRoutes[$uri][$_SERVER['REQUEST_METHOD']]['instance'];
      $action = self::$registeredRoutes[$uri][$_SERVER['REQUEST_METHOD']]['action'] ?? $action;
    }
    call_user_func(array($controller, $action), $id);
  }
  public static function getNameActionAndMethodFromControllerName(string $controller) {
    $parts = explode("@", $controller);
    $methods = explode("#", $parts[1]);
    if (count($methods) == 2) {
      $methods = $methods[1];
      $methods = explode(",", $methods);
    } else {
      $methods = ['GET'];
    }
    $nameIncludingNamespace = $parts[0];
    $hashPosition = strpos($parts[1], "#");
    if ($hashPosition === FALSE) {
      $actionToTake = $parts[1];
    } else {
      $actionToTake = substr($parts[1], 0, strpos($parts[1], "#")); 
    }
    $returnedValue = array_merge(array($nameIncludingNamespace, $actionToTake), $methods);
    var_dump("RET VAL:");
    var_dump($returnedValue);
    return $returnedValue;
  }

  private static function parseURIActionAndParam(string $url) {
    $action = 'none';
    $id = -1;
    $posIndexPhp = substr($url, strpos($url, "index.php")+strlen("index.php")+1);
    $parts = explode("/", $posIndexPhp);
    $uri = $posIndexPhp;

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
            echo "ACTION HERE $parts[1]";
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
    $ret = array($uri, $action, $id);
    return $ret;
  }
} 