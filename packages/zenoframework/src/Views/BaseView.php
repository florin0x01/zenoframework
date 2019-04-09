<?php
namespace ZenoFramework\Views;

class BaseView
{
    public static function renderJSON($data, $status = 200)
    {
        http_response_code($status);
        echo json_encode($data);
    }
}
