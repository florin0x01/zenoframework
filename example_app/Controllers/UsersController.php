<?php
namespace Florin\MyApp\Controllers;
use ZenoFramework\Controllers\DummyController;
use ZenoFramework\Views\BaseView;

class UsersController extends DummyController {
  public function __construct() {
    parent::__construct("User");
  }

  public function index() {
    echo "Users Controller index here";
  }
  public function create() {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $avatar = $_POST['avatar'] ?? 'none';
    $creationResponse = this->mapper->create(array(
      'email' => $email,
      'first_name' => $first_name,
      'last_name' => $last_name,
      'password' => $password,
      'avatar' => $avatar
    ));
    BaseView::renderJSON(['status' => $creationResponse]);
  }
  public function edit($param) {
    echo "Editing user , param $param";
  }
  public function list($id) {
    echo "List id, $id";
  }
}
