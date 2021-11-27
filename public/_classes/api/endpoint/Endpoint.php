<?php

namespace vezit\_classes\api\endpoint;

require __DIR__.'/../../../global-requirements.php';

use vezit\_classes\error as Error;

class Endpoint implements IEndpoint
{
  public $get_parameter;
  public $body;
  private $controller_file_location;

  public function __construct($controller_file_location)
  {
    $this->controller_file_location = $controller_file_location;
    $this->get_parameter = new \stdClass();
  }

  public function set_expected_get_parameters(array $expected_get_parameters) : void
  {
    foreach ($expected_get_parameters as $parameter) {
      if(array_key_exists($parameter, $_GET))
      {
        $this->get_parameter->$parameter = $_GET[$parameter];
      } 
      else {
        $error_message = "expected GET parameter ($parameter) does not exist.";
        new Error\Error($this->controller_file_location, $error_message, $fatal_error=true);
      }
    }
  }

  public function set_expected_body_properties(array $expected_body_properties) : void {
    $body_array = json_decode(file_get_contents("php://input"), true);
    foreach ($expected_body_properties as $property) {
      if((array_key_exists($property, $body_array)))
      {
        $this->body->$property = $body_array[$property];
      }
      else {
        $error_message = "body property ($property) does not exist.";
        new Error\Error($this->controller_file_location, $error_message, $fatal_error=true);
      }
    }
  }
  
  public function set_body(string $json) : void
  {
    $this->body = new \stdClass();
    $this->body = json_decode($json);
  }
}
