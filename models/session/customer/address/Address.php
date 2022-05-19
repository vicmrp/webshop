<?php
namespace vezit\models\session\customer\address;

class Address {

  public function __construct(
      public ?string $street        = null,
      public ?string $postal_code   = null,
      public ?string $city          = null
  ) {}

}
