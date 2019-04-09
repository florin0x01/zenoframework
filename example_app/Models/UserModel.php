<?php
namespace Florin\MyApp\Models;

use ZenoFramework\Models\BaseModel;

class UserModel extends BaseModel
{
    public $email;
    public $first_name;
    public $last_name;
    public $password;
    public $avatar;
}
