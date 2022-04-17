<?php

namespace vezit\dto\class\session\order\order_status\payment;

class Payment
{

    public function __construct(
        public bool $accepted = false,
        public string $currency = 'DKK',
        public int $amount,
        public int $payment_quickpay_id,
        public bool $payment_details_satisfied
    ) {}

}
