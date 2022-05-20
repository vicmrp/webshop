<?php namespace vezit\dto;

class Login_Response {
    public function __construct(
      public ?string  $email = null,
      public ?bool    $access_granted = null,
      public ?bool    $session_variable_isset = null,
      public ?string  $message = null
      ) {}
  }
