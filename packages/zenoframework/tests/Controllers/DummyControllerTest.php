<?php
use PHPUnit\Framework\TestCase;
use ZenoFramework\Controllers\DummyController;
use ZenoFramework\Config\SqlConfig;

final class DummyControllerTest extends TestCase
{
    public function testCannotSetAdapterMapperWithoutConfig()
    {
        $this->expectException(Exception::class);
        $controller = new DummyController();
    }
    public function testCanSetAdapterMapper()
    {
        SqlConfig::setConnectionDetails('production', 'dsn');
        $controller = new DummyController();
        $this->assertEquals(1, 1);
    }
    public function testHttpVerb()
    {
        $controller = new DummyController();
        $this->expectException(BadMethodCallException::class);
        $this->assertEquals($controller->httpVerb(), '');
    }
    public function testIndex()
    {
        $controller = new DummyController();
        $this->assertEquals($controller->index(), null);
    }
    public function testCreate()
    {
        $controller = new DummyController();
        $this->expectException(Exception::class);
        $controller->create();
    }
    public function testUpdate()
    {
        $controller = new DummyController();
        $this->expectException(Exception::class);
        $controller->update(1);
    }
    public function testShow()
    {
        $controller = new DummyController();
        $this->expectException(Exception::class);
        $controller->show(1);
    }
    public function testDelete()
    {
        $controller = new DummyController();
        $this->expectException(Exception::class);
        $controller->delete(1);
    }
    public function testSearch()
    {
        $controller = new DummyController();
        $this->expectException(Exception::class);
        $controller->search(array());
    }
}
