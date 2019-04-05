<?php
$loader = require __DIR__ . '/vendor/autoload.php';
require_once 'controllers/UsersController.php';

use Florin\MyApp\UsersController;
use \ZenoFramework\Routing\Router;

$loader->addPsr4("Florin\\MyApp\\", __DIR__."/Controllers");
Router::map(array('users' => 'Florin\MyApp\UsersController'));
Router::serve();

