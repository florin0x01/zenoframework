<?php
namespace ZenoFramework\Config;

interface IConfig
{
    public static function getConnectionDetails($env);
    public static function getCurrentEnvironment();
}
