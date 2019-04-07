<?php
namespace ZenoFramework\Utils;
use ZenoFramework\Adapters\InclusionMode;

final class SqlBuilder {
  private static function Helper_InsertOrDeleteString(string $type, string $table, InclusionMode $mode, ...$args) {
    $query = "$type ";
    $keys = array_keys($args);
    $values = array(); 
    $queryString = implode(",", $keys);
    $query .= $queryString;
    $query .= " FROM $table ";
    if ($mode != InclusionMode::NONE) {
      $query .= " WHERE ";
      foreach($args as $key) {
        $query .= " $key=? $mode";
      }
      //Remove last "AND" or "OR"
      $query = substr($query, 0, -strlen($mode));
      $values = array_values($args);
    }
    return [$query, $values];
  }

  public static function UpdateString(string $table, ...$args) {
    $query = "UPDATE $table SET ";
    foreach($args as $key) {
      $query .= "$key=?,";
    }
    $query = substr($query, 0, -1);
    $values = array_values($args);
    return [$query, $values];
  }

  public static function SelectString(string $table, InclusionMode $mode, ...$args) {
    return self::Helper_InsertOrDeleteString("SELECT ", $table, $mode, $args);
  }
  public static function DeleteString(string $table, InclusionMode $mode, ...$args): string {
    return self::Helper_InsertOrDeleteString("DELETE ", $table, $mode, $args);
  }
  public static function InsertString(string $table, $args): array {
    $query = "INSERT INTO $table (";
    $keys = array_keys($args);
    var_dump("KEYS ");
    var_dump($keys);
    $queryString = implode(",", $keys);
    $query .= $queryString.") VALUES(";
    foreach($args as $key) {
      $query .= "?,";
    }
    $query = substr($query, 0, -1);
    $query .= ")";
    $values = array_values($args);
    return [$query, $values];
  }
}