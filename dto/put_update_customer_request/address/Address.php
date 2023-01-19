<?php

namespace vezit\dto\put_update_customer_request;

class Address
{

    public function __construct(
        public ?string $street        = null,
        public ?string $postal_code   = null,
        public ?string $city          = null
    ) {
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
