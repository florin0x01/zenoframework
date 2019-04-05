<?php
namespace Florin\MyApp;
use ZenoFramework\Controllers\DummyController;

class UsersController extends DummyController {
  public function index() {
    echo "Users Controller index here";
  }
  public function create() {
    echo "Creating user";
  }
  public function edit($param) {
    echo "Editing user , param $param";
  }
}
