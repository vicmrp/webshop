<?php
namespace vezit\models\session\customer\contact;




class Contact {

  public function __construct(
    public ?string $phone = null,
    public ?string $email = null
  ) {}

}