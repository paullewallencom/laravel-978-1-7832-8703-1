<?php

class Helper {
  public static function sum($arr){ return array_sum($arr); }
}
class HelperTest extends PHPUnit_Framework_TestCase {
  public function testSum(){
    $data = array(1,2,3);              // 1) Arrange
    $result = Helper::sum($data);      // 2) Act
    $this->assertEquals(6, $result);   // 3) Assert
  }
  public function testSomethingElse(){
    // ...
  }
}
