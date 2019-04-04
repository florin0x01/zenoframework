<?php
namespace ZenoFramework\Adapters;
use ZenoFramework\Adapters\SqlInclusionMode;

interface IDataAdapter {
  public function findBy(SqlInclusionMode $mode, ...$args): array;
  public function create(... $args);
  public function delete(... $args);
  public function updateBy(...$args);
}


