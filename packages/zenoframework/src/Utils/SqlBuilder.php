<?php
namespace ZenoFramework\Utils;

use ZenoFramework\Adapters\InclusionMode;

final class SqlBuilder
{
    public static function DeleteString(string $table, string $mode, $args)
    {
        $query = "DELETE FROM $table WHERE ";
        $keys = array_keys($args);
        $values = array();
        foreach ($keys as $key) {
            $query .= " $key=? $mode";
        }
        //Remove last "AND" or "OR"
        $query = substr($query, 0, -strlen($mode));
        $values = array_values($args);
        print ("Query is $query <br />");
        return [$query, $values];
    }

    public static function UpdateString(string $table, $destArgs, $fromId)
    {
        print ("UpdateString $table $fromId ");
        print_r($destArgs);
        $query = "UPDATE $table SET ";
        foreach ($destArgs as $key => $val) {
            $query .= "$key=?,";
        }
        $query = substr($query, 0, -1);
        $query .= " WHERE id=$fromId";
        print ("Query is $query <br />");
        $values = array_values($destArgs);
        return [$query, $values];
    }

    public static function SelectString(string $table, string $mode, $args): array
    {
        $query = "SELECT * FROM $table ";
        $keys = array_keys($args);
        $values = [];
        if ($mode != InclusionMode::NONE && count($args)) {
            $query .= " WHERE ";
            foreach ($keys as $key) {
                $query .= " $key=? $mode";
            }
            //Remove last "AND" or "OR"
            $query = substr($query, 0, -strlen($mode));
            $values = array_values($args);
        }
        print ("Query is $query <br />");
        return [$query, $values];
    }

    public static function InsertString(string $table, $args): array
    {
        $query = "INSERT INTO $table (";
        $keys = array_keys($args);
        $queryString = implode(",", $keys);
        $query .= $queryString.") VALUES(";
        foreach ($args as $key) {
            $query .= "?,";
        }
        $query = substr($query, 0, -1);
        $query .= ")";
        $values = array_values($args);
        return [$query, $values];
    }
}
