<?php
namespace vezit\dto\class\session\order\order_status\email;


class Email {

  public function __construct(
      public bool $confirmation_sent = false,
      public bool $invoice_sent_to_customer = false
  ) {}

}
