<?php
namespace Florin\MyApp\Controllers;
use Florin\MyApp\Models;
use ZenoFramework\Controllers\DummyController;
use ZenoFramework\Views\BaseView;
use ZenoFramework\Adapters\InclusionMode;

class UsersController extends DummyController {
  public function __construct() {
    parent::__construct('Florin\MyApp\Models', 'User');
  }

  public function index() {
    $u = $this->mapper->findBy(InclusionMode::NONE, array());
    BaseView::renderJSON($u);
  }
  public function create() {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $avatar = $_POST['avatar'] ?? 'none';

    $creationResponse = $this->mapper->create(array(
      'email' => $email,
      'first_name' => $first_name,
      'last_name' => $last_name,
      'password' => $password,
      'avatar' => $avatar
    ));
    BaseView::renderJSON(['status' => $creationResponse]);
  }
  public function edit($id) {
    parse_str(file_get_contents('php://input'), $_PUT);
    $updateResponse = $this->mapper->updateBy($_PUT, $id);
    BaseView::renderJSON(['status' => $updateResponse]);
  }
  public function handleListOrDelete($id) {
    if ($this->httpVerb() == "GET") {
      $this->list($id);
    } else if ($this->httpVerb() == "DELETE") {
      $this->delete($id);
    }
  }

  public function list($id) {
    $u = $this->mapper->findBy(InclusionMode::AND, array('id' => $id));
    BaseView::renderJSON($u);
  }

  public function delete($id) {
    $response = $this->mapper->delete(InclusionMode::NONE, array('id' => $id));
    BaseView::renderJSON(['status' => $response]);
  }
}
