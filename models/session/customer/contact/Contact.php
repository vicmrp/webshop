<?php
namespace vezit\models\session\customer\contact;




class Contact {

  public function __construct(
    public ?string $email = null
  ) {}

  public function __set($name, $value)
  {
      throw new \Exception('Cant set!' . $name . ', ' . $value);
  }
}