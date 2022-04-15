<?php
namespace vezit\classes\session\order\order_status\payment;

class Payment implements \JsonSerializable {
  private $accepted = false;
  private $currency = 'DKK';
  private $amount = null;
  private $payment_quickpay_id = null;
  private $payment_details_satisfied = null;

  public function __construct() {

  }

  public function set_payment_quickpay_id($payment_quickpay_id)
  {
    $this->payment_quickpay_id = $payment_quickpay_id;
  }

  public function get_payment_quickpay_id()
  {
    return $this->payment_quickpay_id;
  }

  public function set_payment_details_satisfied($payment_details_satisfied)
  {
    $this->payment_details_satisfied = $payment_details_satisfied;
  }

  public function get_payment_details_satisfied()
  {
    return $this->payment_details_satisfied;
  }


  public function set_accepted(bool $accepted) : void {
    $this->accepted = $accepted;
  }


  public function set_currency($currency) : void {
    $this->currency = $currency;
  }

  public function set_amount($amount) : void {
    $this->amount = $amount;
  }

  public function get_amount() {
    return $this->amount;
  }

  public function set_accumulated_amount(array $order_items) : void
  {
    // Opdater amount fæltet    
    $amount = 0;
    foreach ($order_items as $order_item) {
        $price = $order_item->get_price();
        $quantity = $order_item->get_quantity();
        $amount = $amount + $price * $quantity;
    }
    $this->amount = $amount;
  }

  public function get_accumulated_amount()
  {
    return $this->amount;
  }

  // Includes private properties in json_encode()
  public function jsonSerialize()
  {
      $vars = get_object_vars($this);

      return $vars;
  }
}
