<?php
namespace Florin\MyApp\Controllers;
use ZenoFramework\Controllers\DummyController;

class UsersController extends DummyController {

  public function __construct() {
    parent::__construct("User");
  }

  public function index() {
    echo "Users Controller index here";
  }
  public function create() {
    echo "Creating user";
  }
  public function edit($param) {
    echo "Editing user , param $param";
  }
  public function list($id) {
    echo "List id, $id";
  }
}
