<?php
use PHPUnit\Framework\TestCase;
use ZenoFramework\Models\BaseModel;

class MockModel extends BaseModel
{
    public $field1;
    public $field2;
}

class Row
{
    public $field1;
    public $field2;

    public function __construct($f1, $f2)
    {
        $this->field1 = $f1;
        $this->field2 = $f2;
    }
}

$mockDataArr = ['1' => ['field1' => 'f1', 'field2' => 'f2'],
                '2' => ['field1' => 'f3', 'field2' => 'f4'] ];

$mockDataRows = [
    '1' => new Row('f1', 'f2'),
    '2' => new Row('f3', 'f4')
];

final class BaseModelTest extends TestCase
{
    public function testCanReturnFromUpperModel()
    {
        global $mockDataArr;
        $objects = MockModel::fromState($mockDataArr);
        $this->assertEquals(count($objects), 2);
        $this->assertEquals($objects[0]->field1, 'f1');
        $this->assertEquals($objects[0]->field2, 'f2');
        $this->assertEquals($objects[1]->field1, 'f3');
        $this->assertEquals($objects[1]->field2, 'f4');
    }
    public function testCanReturnFromUpperModelUsingObject()
    {
        global $mockDataRows;
        $objects = MockModel::fromState($mockDataRows);
        $this->assertEquals(count($objects), 2);
        $this->assertEquals($objects[0]->field1, 'f1');
        $this->assertEquals($objects[0]->field2, 'f2');
        $this->assertEquals($objects[1]->field1, 'f3');
        $this->assertEquals($objects[1]->field2, 'f4');
    }
}
