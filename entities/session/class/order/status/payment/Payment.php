<?php

namespace vezit\entities\class\order\status\payment;

class Payment
{

    public function __construct(
        public bool $accepted = false,
        public string $currency = 'DKK',
        public int $amoun = 0,
        public int $quickpay_id = 0,
        public bool $details_satisfied = false
    ) {}

}
