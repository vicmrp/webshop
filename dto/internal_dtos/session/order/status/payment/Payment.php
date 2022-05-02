<?php

namespace vezit\dto\internal_dtos\session\order\status\payment;

class Payment
{

    public function __construct(
        public bool $accepted = false,
        public string $currency = 'DKK',
        public int $amount = 0,
        public int  $quickpay_id = 0,
        public bool $details_satisfied_for_payment = false
    ) {}

}
