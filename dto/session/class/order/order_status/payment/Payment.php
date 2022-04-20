<?php

namespace vezit\dto\class\session\order\order_status\payment;

class Payment
{

    public function __construct(
        public bool $accepted = false,
        public string $currency = 'DKK',
        public int $amoun = 0,
        public int $payment_quickpay_id = 0,
        public bool $payment_details_satisfied = false
    ) {}

}
