<?php
namespace vezit\classes\order\order_status;

class Payment
{
  public $accepted;
  public $currency;
  public $amount;

  public function __construct($accepted, $currency, $amount) {
    $this->accepted = $accepted;
    $this->currency = $currency;
    $this->amount = $amount;
  }
}
