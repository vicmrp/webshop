<?php

namespace vezit\dto\internal_dtos\session\order\status\payment;

class Payment
{

    public function __construct(
        public  ?bool   $accepted                           = null,
        public  ?string $currency                           = null,
        public  ?int    $amount                             = null,
        public  ?int    $quickpay_id                        = null,
        public  ?bool   $details_satisfied_for_payment      = null
    ) {}

}
