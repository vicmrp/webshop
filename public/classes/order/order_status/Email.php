<?php
namespace vezit\classes\order\order_status;

class Email
{
  public $confirmation_sent;
  public $invoice_sent;

  public function __construct($confirmation, $invoice_sent) {
    $this->confirmation_sent = $confirmation_sent;
    $this->invoice_sent = $invoice_sent;
  }
}
