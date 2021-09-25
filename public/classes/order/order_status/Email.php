<?php
namespace vezit\classes\order\order_status;

class Email implements \JsonSerializable {
  private $confirmation_sent;
  private $invoice_sent;

  public function __construct($confirmation_sent, $invoice_sent) {
    $this->confirmation_sent = $confirmation_sent;
    $this->invoice_sent = $invoice_sent;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
