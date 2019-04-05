<?php
namespace ZenoFramework\Mappers;
use ZenoFramework\Adapters\IDataAdapter; 
use ZenoFramework\Adapters\InclusionMode;

class ZenoMapper {
  private $adapter;
  private $modelToReturn;

  public function __construct(IDataAdapter $adapter, $modelToReturn) {
    $this->adapter = $adapter;
    $this->modelToReturn = $modelToReturn;
  }
  public function findBy(InclusionMode $mode, ... $args) {
    $result = $this->adapter->findBy($mode, $args);
    if ($result === null) {
      throw new \InvalidArgumentException("Record not found , supplied args: ".implode(" ", $args));
    }
    return $this->rowToModel($result);
  }

  public function create(InclusionMode $mode, ... $args) {
    $result = $this->adapter->create($mode, $args);
    if ($result === null) {
      throw new \InvalidArgumentException("Record not created , supplied args: ".implode(" ", $args));
    }
    return $this->rowToModel($result);
  }

  public function delete(InclusionMode $mode, ... $args) {
    $result = $this->adapter->delete($mode, $args);
    if ($result === null) {
      throw new \InvalidArgumentException("Record not found , supplied args: ".implode(" ", $args));
    }
    return $this->rowToModel($result);
  }

  public function updateBy(... $args) {
    $result = $this->adapter->updateBy($args);
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