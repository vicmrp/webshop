<?php
namespace vezit\classes\session\order\order_status;

class Email implements \JsonSerializable {
  private $confirmation_sent;
  private $invoice_sent;

  public function __construct($confirmation_sent, $invoice_sent) {
    $this->confirmation_sent = $confirmation_sent;
    $this->invoice_sent = $invoice_sent;
  }

  public function set_confirmation_sent($confirmation_sent)
  {
    $this->confirmation_sent = $confirmation_sent;
  }

  public function get_confirmation_sent()
  {
    return $this->confirmation_sent;
  }

  public function set_invoice_sent($invoice_sent)
  {
    $this->invoice_sent = $invoice_sent;
  }

  public function get_invoice_sent()
  {
    return $this->invoice_sent;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
