<?php
namespace vezit\dto\class\session\customer\address;

class Address {

  public function __construct(
      public string $street,
      public int $postal_code,
      public string $city
  ) {}

}
