<?php
namespace ZenoFramework\Config;

class SqlConfig implements IConfig
{
    private static $conn;
    private static $env;
    public static function getConnectionDetails($env)
    {
        if (!$env || !array_key_exists($env, self::$conn)) {
            throw new \Exception("No such env $env");
        }
        return self::$conn[$env];
    }
    public static function setConnectionDetails($env, $dsn)
    {
        self::$env = $env;
        self::$conn[$env] = $dsn;
    }
    public static function getCurrentEnvironment()
    {
        return self::$env;
    }
    public static function setCurrentEnvironment($env)
    {
        self::$env = $env;
    }
}
