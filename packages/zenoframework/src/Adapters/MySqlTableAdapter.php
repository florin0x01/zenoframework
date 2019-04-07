<?php
namespace ZenoFramework\Adapters;
use ZenoFramework\Adapters\InclusionMode;
use ZenoFramework\Utils\SqlBuilder;
use ZenoFramework\Config\Sql;

class MySqlTableAdapter implements IDataAdapter {
  private $connection;
  protected $table;

  public function setConnectionDetails($connection, $table) {
    $this->connection = $connection;
    $this->table = $table; 
  }
    
  public function findBy(InclusionMode $mode, ...$args): array {
    list($query, $values) = SqlBuilder::SelectString($this->table, $mode, $args);
    $prepared = $this->connection->prepare($query);
    $prepared->execute($values);
    $results = $prepared->fetchAll();
    return $results;
  } 
  public function updateBy(...$args): array {
    list($query, $values) = SqlBuilder::UpdateString($this->table, $args);
    $prepared = $this->connection->prepare($query);
    $prepared->execute($values);
    $results = $prepared->fetchAll();
    return $results;
  }
  public function create($args) {
    list ($query, $values) = Sqlbuilder::InsertString($this->table, $args);
    var_dump("Query: $query");
    var_dump("VALUES ");
    var_dump($values);
    $prepared = $this->connection->prepare($query);
    $res = $prepared->execute($values);
    if ($res == false) {
      return json_encode($prepared->errorInfo());
    }
    return $res;
  }
  public function delete(InclusionMode $mode, ... $args) {
    list($query, $values) = SqlBuilder::DeleteString($this->table, $mode, $args);
    $prepared = $this->connection->prepare($query);
    return $prepared->execute($values);
  }
}