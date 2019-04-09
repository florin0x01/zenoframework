<?php
use PHPUnit\Framework\TestCase;
use ZenoFramework\Adapters\MySqlTableAdapter;
use ZenoFramework\Adapters\InclusionMode;

$mockedData = array(
        'first_name' => 'First name',
        'last_name' => 'Last Name',
        'password' => 'Password',
        'email' => 'email@email.com',
        'avatar' => 'avatar'
        );

final class MockPrepareError
{
    public function execute($values)
    {
        return false;
    }
    public function fetchAll()
    {
        global $mockedData;
        return array($mockedData);
    }
    public function errorInfo() : string
    {
        return "Error";
    }
}

final class MockPrepare
{
    public function execute($values)
    {
        return true;
    }
    public function fetchAll()
    {
        global $mockedData;
        return array($mockedData);
    }
    public function errorInfo() : string
    {
        return "Error";
    }
}

final class MockConnection
{
    public function prepare()
    {
        return new MockPrepare();
    }
}

final class MockConnectionErr
{
    public function prepare()
    {
        return new MockPrepareError();
    }
}

final class MySqlTableAdapterTest extends TestCase
{
    private $adapter, $adapter2, $conn, $connErr;
    public function __construct()
    {
        parent::__construct();
        
        $this->adapter2 = new MySqlTableAdapter();
        $this->connErr = new MockConnectionErr();
        $this->adapter2->setConnectionDetails($this->connErr, "table");

        $this->adapter = new MySqlTableAdapter();
        $this->conn = new MockConnection();
        $this->adapter->setConnectionDetails($this->conn, "table");
    }
    public function testCanFindBy()
    {
        $res = $this->adapter->findBy(InclusionMode::AND, array('id' => 1));
        $this->assertEquals(count($res), 1);
    }
    public function testCanUpdateByAndSendError()
    {
        $res = $this->adapter2->updateBy(array('email' => 'email2@email.com'), 1);
        $this->assertEquals($res, '"Error"');
    }
    public function testCanUpdateBy()
    {
        $res = $this->adapter->updateBy(array('email' => 'email2@email.com'), 1);
        $this->assertEquals($res, true);
    }
    public function testCanCreate()
    {
        global $mockedData;
        $res = $this->adapter->create($mockedData, 1);
        $this->assertEquals($res, true);
    }
    public function testCanCreateAndSendError()
    {
        global $mockedData;
        $res = $this->adapter2->create($mockedData, 1);
        $this->assertEquals($res, '"Error"');
    }
    public function testCanDelete()
    {
        $res = $this->adapter->delete(InclusionMode::NONE, array('id'=>1));
        $this->assertEquals($res, true);
    }
}
