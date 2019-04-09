<?php
namespace ZenoFramework\Controllers;

use ZenoFramework\Adapters;
use ZenoFramework\Mappers;
use ZenoFramework\Config\SqlConfig;

class DummyController
{
    protected $mapper;

    public function __construct(
        $namespace = "",
        $modelStr = "",
        $adapterStr = 'ZenoFramework\Adapters\MySqlTableAdapter',
        $mapperStr = 'ZenoFramework\Mappers\ZenoMapper'
    ) {
        $this->setAdapterMapper($namespace, $adapterStr, $mapperStr, $modelStr);
    }

    private function setAdapterMapper($namespace, $adapterClassName, $mapperClassName, $modelStr)
    {
        $adapter = new $adapterClassName();
        $dsObjectName = strtolower($modelStr)."s";
        $adapter->setConnectionDetails(
            SqlConfig::getConnectionDetails(SqlConfig::getCurrentEnvironment()),
            $dsObjectName
        );
        $this->mapper = new $mapperClassName($adapter, $namespace."\\".$modelStr."Model");
    }

    protected function httpVerb()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function none()
    {
        throw new \BadMethodCallException("Invalid Action / route");
    }

    public function __call(string $name, array $arguments)
    {
        throw new \BadMethodCallException("Tried to access inexistent method $name");
    }

    public function index()
    {
        echo "<br />Dummy index";
    }
  /**
   * Creates the resource
   */
    public function create()
    {
        throw new Exception("Please implement this in the parent class");
    }

  /**
   * Shows the resource with specified id
   *
   * @param int $id
   */
    public function show($id)
    {
        throw new Exception("Please implement this in the parent class");
    }

  /**
   * Update the resource with specified id
   *
   * @param int $id
   */
    public function update($id)
    {
        throw new Exception("Please implement this in the parent class");
    }

  /**
   * Deletes the resource
   *
   * @param int $id
   */
    public function delete($id)
    {
        throw new Exception("Please implement this in the parent class");
    }

  /**
   * Searches by some params
   */
    public function search(array $params)
    {
        throw new Exception("Please implement this in the parent class");
    }
}
