<?php
namespace ZenoFramework\Config;

class SqlConfig implements IConfig {
	private static $conn;
	private static $env;
	public static function getConnectionDetails($env) {
		return self::$conn[$env];
	}	
	public static function setConnectionDetails($env, $dsn) {
		self::$conn[$env] = $dsn;
	}
	public static function getCurrentEnvironment() {
		return self::$env;
	}
	public static function setCurrentEnvironment($env) {
		self::$env = $env;
	}
}