<?php

namespace vezit\dto\class\session\shipment\address;

class Address
{

    public function __construct(
        public string $street_name,
        public string $street_number,
        public int $postal_code,
        public string $city
    ) {}

}
