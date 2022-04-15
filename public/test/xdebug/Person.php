<?php

class Person
{
  private $name;
  private $age;

  function __construct($name, $age)
  {
    $this->name = $name;
    $this->age = $age;
  }

  public function get_name()
  {
    return $this->name;
  }
}
