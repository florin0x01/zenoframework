<?php
use PHPUnit\Framework\TestCase;
use ZenoFramework\Mappers\ZenoMapper;
use ZenoFramework\Adapters\IDataAdapter;
use ZenoFramework\Models\BaseModel;

class MockModel extends BaseModel
{
    public $field1;
    public $field2;
}

$mockDataArr = ['1' => [ 0 => ['field1' => 'f1', 'field2' => 'f2'] ],
                '2' => [ 0 => ['field1' => 'f3', 'field2' => 'f4'] ] ];

final class MockAdapter implements IDataAdapter
{
    public function findBy(string $mode, array $args)
    {
        global $mockDataArr;
        $obj = $mockDataArr[$args['id']];
        return $obj;
    }
    public function create(array $args)
    {
        return true;
    }
    public function delete(string $mode, array $args)
    {
        return true;
    }
    public function updateBy(array $destArgs, string $id)
    {
        $mockData[$id][0] = $destArgs;
        return true;
    }
    public function setConnectionDetails($connectionObj, $dataSourceObj)
    {
        return true;
    }
};

final class MockAdapterErr implements IDataAdapter
{
    public function findBy(string $mode, array $args)
    {
        global $mockDataArr;
        $obj = $mockDataArr[$args['id']];
        return $obj;
    }
    public function create(array $args)
    {
        return null;
    }
    public function delete(string $mode, array $args)
    {
        return null;
    }
    public function updateBy(array $destArgs, string $id)
    {
        return null;
    }
    public function setConnectionDetails($connectionObj, $dataSourceObj)
    {
        return null;
    }
}

final class ZenoMapperTest extends TestCase
{
    private $model, $adapter, $mapper;
    public function __construct()
    {
        parent::__construct();
        $this->adapter = new MockAdapter();
        $this->model = '\MockModel';
        $this->mapper = new ZenoMapper($this->adapter, $this->model);

        $this->adapter_err = new MockAdapterErr();
        $this->model = '\MockModel';
        $this->mapper_err = new ZenoMapper($this->adapter_err, $this->model);
    }
    public function testCanFindBy()
    {
        global $mockDataArr;
        $obj = $this->mapper->findBy('AND', array('id' => '1'));
        $this->assertEquals($obj->field1, $mockDataArr['1']['0']['field1']);
        $this->assertEquals($obj->field2, $mockDataArr['1']['0']['field2']);
    }
    public function testCanCreate()
    {
        $this->assertEquals($this->mapper->create(array()), true);
    }
    public function testCanDelete()
    {
        $this->assertEquals($this->mapper->delete('', array()), true);
    }
    public function testCanUpdateby()
    {
        $this->assertEquals($this->mapper->updateBy(array('1', '2'), 1), true);
    }
    public function testCanCreateErr()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->mapper_err->create(array());
    }
    public function testCanDeleteErr()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->mapper_err->delete('', array());
    }
    public function testCanUpdatebyErr()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->mapper_err->updateBy(array('1', '2'), 1);
    }
}
