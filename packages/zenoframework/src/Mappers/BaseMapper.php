<?php
namespace ZenoFramework\Mappers;
use ZenoFramework\Adapters\IDataAdapter; 

class BaseMapper {
  private $adapter;
  private $modelToReturn;

  public function __construct(IDataAdapter $adapter, $modelToReturn) {
    $this->adapter = $adapter;
    $this->modelToReturn = $modelToReturn;
  }
  public function findBy(... $args) {
    $result = $this->adapter->findBy($args);
    if ($result === null) {
      throw new \InvalidArgumentException("Record not found , supplied args: ".implode(" ", $args));
    }
    return $this->rowToModel($result);
  }
  private function rowToModel(array $row)
  {
    return call_user_func(["$this->modelToReturn", "fromState", $row]);
  }
}