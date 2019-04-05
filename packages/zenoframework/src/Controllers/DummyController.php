<?php
namespace ZenoFramework\Controllers;

class DummyController {
  /**
   * Lists the resource 
   */

  public function none() {
    throw new \BadMethodCallException("Invalid Action / route");
  }

  public function __call ( string $name , array $arguments ) {
    throw new \BadMethodCallException("Tried to access inexistent method $name");
  }

  public function index() {
    echo "<br />Dummy index";
  }
  /**
   * Creates the resource
   */
  public function create() {

  }

  /**
   * Shows the resource with specified id
   * 
   * @param int $id
   */
  public function show($id) {

  }

  /**
   * Update the resource with specified id
   * 
   * @param int $id
   */
  public function update($id) {

  }

  /**
   * Deletes the resource
   * 
   * @param int $id
   */
  public function delete($id) {

  }

  /**
   * Searches by some params
   */
  public function search(array $params) {

  }

}