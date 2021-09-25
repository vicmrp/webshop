<?php

class Contact {
  public $phone;
  public $email;

  public function __construct($phone, $email) {
    $this->phone = $phone;
    $this->email = $email;
  }
}