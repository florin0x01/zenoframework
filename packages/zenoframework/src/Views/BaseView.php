<?php
namespace ZenoFramework\Views;

class Base {
  public static function renderJSON(array $data) {
    echo json_encode($data);
  }
  private function __construct() {

  }
}