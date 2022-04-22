<?php

namespace vezit\entities\class\shipment\address;

class Address
{

    public function __construct(
        public string $street_name = '',
        public string $street_number = '',
        public string $postal_code = '',
        public string $city = ''
    ) {}

}
