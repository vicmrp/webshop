<?php

namespace vezit\models\session\order\status\payment;

class Payment
{

    public function __construct(
        public  ?bool   $accepted                           = null,
        public  ?string $currency                           = null,
        public  ?int    $amount                             = null,
        public  ?int    $quickpay_id                        = null
    ) {}


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
