<?php
namespace ZenoFramework\Models;

class BaseModel
{
    public static function fromState($rows)
    {
        $calledClass = get_called_class();
        $returnedObjects = array();
        foreach ($rows as $index => $row) {
            $obj = new $calledClass();
            $cVars = get_class_vars($calledClass);
            foreach ($cVars as $variable => $val) {
                if (is_object($row)) {
                    $obj->$variable = $row->$variable ?? null;
                } else {
                    $obj->$variable = $row[$variable] ?? null;
                }
            }
            $returnedObjects[] = $obj;
        }
        if (count($returnedObjects)>1) {
            return $returnedObjects;
        }
        return @$returnedObjects[0];
    }
}
