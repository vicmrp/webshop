<?php
namespace vezit\models\session\order\status\email;


class Email {

  public function __construct(
      public ?bool $invoice_sent_to_customer    = null
  ) {}


  public function __set($name, $value)
  {
      throw new \Exception('Cant set!' . $name . ', ' . $value);
  }
}
