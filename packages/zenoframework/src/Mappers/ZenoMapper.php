<?php
namespace ZenoFramework\Mappers;

use ZenoFramework\Adapters\IDataAdapter;
use ZenoFramework\Adapters\InclusionMode;

class ZenoMapper
{
    private $adapter;
    private $modelToReturn;

    public function __construct(IDataAdapter $adapter, $modelToReturn)
    {
        $this->adapter = $adapter;
        $this->modelToReturn = $modelToReturn;
    }
    public function findBy(string $mode, $args)
    {
        $result = $this->adapter->findBy($mode, $args);
        if ($result === null) {
            throw new \InvalidArgumentException("Record not found , supplied args: ".implode(" ", $args));
        }
        return $this->rowToModel($result);
    }

    public function create($args)
    {
        $result = $this->adapter->create($args);
        if ($result === null) {
            throw new \InvalidArgumentException("Record not created , supplied args: ".implode(" ", $args));
        }
        if (is_array($result)) {
            return $this->rowToModel($result);
        }
        return $result;
    }

    public function delete($mode, $args)
    {
        $result = $this->adapter->delete($mode, $args);
        if ($result === null) {
            throw new \InvalidArgumentException("Record not found , supplied args: ".implode(" ", $args));
        }
        if (is_array($result)) {
            return $this->rowToModel($result);
        }
        return $result;
    }

    public function updateBy($args, $id)
    {
        $result = $this->adapter->updateBy($args, $id);
        if ($result === null) {
            throw new \InvalidArgumentException("Record not found , supplied args: ".implode(" ", $args));
        }
        return $result;
    }

    private function rowToModel(array $row)
    {
        $callable_cb = "$this->modelToReturn::fromState";
        return call_user_func($callable_cb, $row);
    }
}
