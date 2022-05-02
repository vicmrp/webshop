<?php
namespace vezit\dto\internal_dtos\session\customer\address;

class Address {

  public function __construct(
      public string $street = '',
      public string $postal_code = '',
      public string $city = ''
  ) {}

}
