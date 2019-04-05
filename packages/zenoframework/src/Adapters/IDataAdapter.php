<?php
namespace ZenoFramework\Adapters;
use ZenoFramework\Adapters\InclusionMode;

interface IDataAdapter {
  public function findBy(InclusionMode $mode, ...$args): array;
  public function create(InclusionMode $mode, ...$args);
  public function delete(InclusionMode $mode, ...$args);
  public function updateBy(...$args);
}


