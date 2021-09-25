<?php
namespace vezit\classes\customer;

class Company implements \JsonSerializable {

  private $cvr_number;
  private $company_name;

  public function __construct($cvr_number, $company_name) {
    $this->cvr_number = $cvr_number;
    $this->company_name = $company_name;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}