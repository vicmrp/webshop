<?php namespace vezit\entities;
require __DIR__ . '/../global-requirements.php';

class Order {

    public function __construct(
        public ?int         $pk = null,
        public ?string      $order_id = null,
        public ?\DateTime   $datetime_created = null,
        public ?\DateTime   $datetime_modified = null,
        public ?string      $order_status_payment_currency = null,
        public ?int         $order_status_payment_total_amount = null,
        public ?string      $order_status_payment_quickpay_id = null,
        public ?bool        $order_status_email_invoice_and_product_sent_to_customer = null,
        public ?string      $customer_fullname = null,
        public ?bool        $customer_tos_and_tac_has_been_accepted = null,
        public ?string      $customer_contact_email = null,
    ) {}
}