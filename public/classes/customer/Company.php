<?php
namespace vezit\classes\customer {
  class Company
  {
    public $cvr_number;
    public $company_name;

    public function __construct($cvr_number, $company_name) {
      $this->cvr_number = $cvr_number;
      $this->company_name = $company_name;
    }
  }
}