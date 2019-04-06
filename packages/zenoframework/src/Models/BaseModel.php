<?php
namespace ZenoFramework\Models;

class BaseModel {
  public static function fromState($ar) {
  	$calledClass = get_called_class();
  	$obj = new $calledClass();
  	$cVars = get_class_vars($calledClass);
  	foreach($cVars as $variable=>$val) {
  		$obj->$variable = $ar[$variable] ?? NULL;
  	}
  	return $obj;
  }
}