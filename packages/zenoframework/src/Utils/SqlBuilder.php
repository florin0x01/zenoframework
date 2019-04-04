<?php
namespace ZenoFramework\Utils;
use ZenoFramework\Adapters\SqlInclusionMode;


final class SqlBuilder {
  private static function Helper_InsertOrDeleteString(string $type, string $table, SqlInclusionMode $mode, ...$args) {
    $query = "$type ";
    $keys = array_keys($args);
    $values = array(); 
    $queryString = implode(",", $keys);
    $query .= $queryString;
    $query .= " FROM $table ";
    if ($mode != SqlInclusionMode::NONE) {
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

  public static function SelectString(string $table, SqlInclusionMode $mode, ...$args) {
    return self::Helper_InsertOrDeleteString("SELECT ", $table, $mode, $args);
  }
  public static function DeleteString(string $table, SqlInclusionMode $mode, ...$args): string {
    return self::Helper_InsertOrDeleteString("DELETE ", $table, $mode, $args);
  }
  public static function InsertString(string $table, SqlInclusionMode $mode, ...$args): string {
    $query = "INSERT INTO $table (";
    $keys = array_keys($args);
    $queryString = implode(",", $keys);
    $query .= $queryString.") VALUES(";
    foreach($args as $key) {
      $query .= "?,";
    }
    $query .= ")";
    $query = substr($query, 0, -1);
    $values = array_values($args);
    return [$query, $values];
  }
}