<?php
namespace ZenoFramework\Views;

class BaseView {
  public static function renderJSON(array $data) {
    echo json_encode($data);
  }
  private function __construct() {

  }
}
