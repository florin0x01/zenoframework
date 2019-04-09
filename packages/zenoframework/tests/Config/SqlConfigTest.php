<?php
use PHPUnit\Framework\TestCase;
use ZenoFramework\Config\SqlConfig;

final class SqlConfigTest extends TestCase
{
    public function testInexistentEnvironmentIsNull()
    {
        //SqlConfig::setCurrentEnvironment('env');
        $this->assertEquals(SqlConfig::getCurrentEnvironment('env'), null);
    }
    public function testCanGetAndSetConnectionDetails()
    {
        SqlConfig::setConnectionDetails('production', 'dsn');
        $this->assertEquals(SqlConfig::getConnectionDetails('production'), 'dsn');
    }
    public function testCanGetEmptyConnectionDetailsForInvalidString()
    {
        $this->expectException(Exception::class);
        SqlConfig::getConnectionDetails('inexistent');
    }
    public function testCanGetCurrentEnvironment()
    {
        SqlConfig::setCurrentEnvironment('env');
        $this->assertEquals(SqlConfig::getCurrentEnvironment('env'), 'env');
    }
}
