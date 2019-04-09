<?php
namespace ZenoFramework\Adapters;

interface IDataAdapter {
  public function findBy(string $mode, $args);
  public function create($args);
  public function delete(string $mode, $args);
  public function updateBy($destArgs, $id);
  public function setConnectionDetails($connectionObj, $dataSourceObj);
}


