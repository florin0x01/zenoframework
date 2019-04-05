<?php
$loader = require __DIR__ . '/vendor/autoload.php';
require_once 'controllers/UsersController.php';

use Florin\MyApp\UsersController;
use ZenoFramework\Routing\Router;

$loader->addPsr4("Florin\\MyApp\\", __DIR__."/Controllers");

Router::map(
  array(
    'users/index' => 'Florin\MyApp\UsersController@index',
    'users' => 'Florin\MyApp\UsersController@index',
    'users/create' => 'Florin\MyApp\UsersController@create',
    'users/{id}/edit' => 'Florin\MyApp\UsersController@edit',
    'users/{id}' => 'Florin\MyApp\UsersController@list'
  )
);

Router::serve();

