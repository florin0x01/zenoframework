<?php
$loader = require __DIR__ . '/vendor/autoload.php';

use Florin\MyApp\Controllers\UsersController;
use Florin\MyApp\Models\UserModel;
use ZenoFramework\Routing\Router;
use ZenoFramework\Config\SqlConfig;

$loader->addPsr4("Florin\MyApp\Controllers\\", __DIR__."/Controllers");
$loader->addPsr4("Florin\\MyApp\\Models\\", __DIR__."/Models");

SqlConfig::setCurrentEnvironment('development');
$dsn = sprintf('mysql:dbname=%s;host=%s', "my_app", "localhost");
$user = "root";
$password = "secret";
$connection = new \PDO($dsn, $user, $password, [
       \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
       \PDO::ATTR_PERSISTENT => true
 ]);

SqlConfig::setConnectionDetails('development', $connection);

Router::map(
  array(
    'users/index' => 'Florin\MyApp\Controllers\UsersController@index',
    'users' => 'Florin\MyApp\Controllers\UsersController@index',
    'users/create' => 'Florin\MyApp\Controllers\UsersController@create#POST',
    'users/{id}/edit' => 'Florin\MyApp\Controllers\UsersController@edit#PUT',
    'users/{id}' => 'Florin\MyApp\Controllers\UsersController@list#GET,DELETE'
  )
);

Router::serve();
$u = UserModel::fromState(
[
  'email' => 'a@a.com',
  'first_name' => 'fistname',
  'last_name' => 'lastname',
  'password' => 'password',
  'avatar' => 'avatar'
]
);
