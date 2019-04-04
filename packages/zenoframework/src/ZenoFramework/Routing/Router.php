<?php
namespace ZenoFramework\Routing;

$loader = require __DIR__ . '/vendor/autoload.php';

class Router {
  const NS_CONTROLLERS = "ZenoFramework\controllers";
  private static $mappedUriToController = array();
  private static $registeredControllers = array();

  public static function map($uri, $controller) {
    self::$registeredControllers[$controller] = 1;
    self::$mappedUriToController[$uri] = $controller;
    $loader->addPsr4(NS_CONTROLLERS. "\\", __DIR__);  
  }
  
  private static function serve($uri) {
    try {
      list($controller, $action, $id) = self::getControllerActionAndId($uri);
      if (!array_key_exists($controller, self::$registeredControllers)) {
        $controller = 'dummy'; 
        $action = 'none';
        $id = -1;
      }
      return call_user_func([NS_CONTROLLERS. "\\$controller", "$action"], $id);
      restore_error_handler();
    } catch(Exception $e) {

    }
  }
  private static function getControllerActionAndId($uri) {
    $controller = 'dummy'; 
    $action = 'none';
    $id = -1;

    $parts = explode("/", $uri);
    if (empty($parts[0])) {
      array_shift($parts);
    }
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

      default:
        $controller = $parts[0];

    } 
    return array($controller, $action, $id);
  }
} 