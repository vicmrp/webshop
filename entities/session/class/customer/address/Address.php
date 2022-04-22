<?php
namespace vezit\entities\class\customer\address;

class Address {

  public function __construct(
      public string $street = '',
      public string $postal_code = '',
      public string $city = ''
  ) {}

}
