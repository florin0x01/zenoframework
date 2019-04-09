<?php
namespace ZenoFramework\Views;

class PNGView
{
    public static function renderImage($data, $status = 200)
    {
        header("Content-type: image/png");
        http_response_code($status);
        echo $data;
    }
}
