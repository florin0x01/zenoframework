<?php
namespace ZenoFramework\Adapters;

interface IDataAdapter
{
    public function findBy(string $mode, array $args);
    public function create(array $args);
    public function delete(string $mode, array $args);
    public function updateBy(array $destArgs, string $id);
    public function setConnectionDetails($connectionObj, $dataSourceObj);
}
