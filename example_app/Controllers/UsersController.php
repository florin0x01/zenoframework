<?php
namespace Florin\MyApp\Controllers;

use Florin\MyApp\Models;
use ZenoFramework\Controllers\DummyController;
use ZenoFramework\Views\BaseView;
use ZenoFramework\Views\PNGView;
use ZenoFramework\Adapters\InclusionMode;

class UsersController extends DummyController
{
    public function __construct()
    {
        parent::__construct('Florin\MyApp\Models', 'User');
    }

    public function index()
    {
        $u = $this->mapper->findBy(InclusionMode::AND, array());
        if (is_array($u)) {
            foreach ($u as $obj) {
                if ($obj->avatar) {
                    $obj->avatar = base64_encode($obj->avatar);
                }
            }
        } else {
            $u->avatar = base64_encode($obj->avatar);
        }
        BaseView::renderJSON($u);
    }
    public function create()
    {
        $email = $_POST['email'] ?? null;
        $first_name = $_POST['first_name'] ?? null;
        $last_name = $_POST['last_name'] ?? null;
        $password = $_POST['password'] ?? null;
        $avatar = $_POST['avatar'] ?? '';

        if (empty($email) || empty($first_name) || empty($last_name) || empty($password)) {
            BaseView::renderJSON(['error' => 'Please supply correct fields'], 400);
            return;
        }
        
        $password = password_hash($password, PASSWORD_DEFAULT);
        if ($avatar) {
            $avatar = str_replace(" ", "+", $avatar);
            echo $avatar;
            $avatar = base64_decode($avatar);
        }
        $creationResponse = $this->mapper->create(array(
        'email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'password' => $password,
        'avatar' => $avatar
        ));
        BaseView::renderJSON(['status' => $creationResponse]);
    }
    public function edit($id)
    {
        parse_str(file_get_contents('php://input'), $_PUT);
        $updateResponse = $this->mapper->updateBy($_PUT, $id);
        BaseView::renderJSON(['status' => $updateResponse]);
    }
    public function handleListOrDelete($id)
    {
        if ($this->httpVerb() == "GET") {
            $this->list($id);
        } elseif ($this->httpVerb() == "DELETE") {
            $this->delete($id);
        }
    }

    public function list($id)
    {
        $u = $this->mapper->findBy(InclusionMode::AND, array('id' => $id));
        if ($u == null) {
            BaseView::renderJSON(array('error' => 'Not found'), 404);
            return;
        }
        if (@$u->avatar) {
            $u->avatar = base64_encode($u->avatar);
        }
        BaseView::renderJSON($u);
    }

    public function user_avatar($id)
    {
        $u = $this->mapper->findBy(InclusionMode::AND, array('id' => $id));
        if ($u == null) {
            BaseView::renderJSON(array('error' => 'Not found'), 404);
            return;
        }
        if (@$u->avatar) {
            PNGView::renderImage($u->avatar);
        } else {
            BaseView::renderJSON(array('error' => 'no image'), 404);
        }
    }

    public function delete($id)
    {
        $response = $this->mapper->delete(InclusionMode::NONE, array('id' => $id));
        BaseView::renderJSON(['status' => $response]);
    }
}
