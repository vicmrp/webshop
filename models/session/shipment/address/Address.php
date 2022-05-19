<?php namespace vezit\models\session\shipment\address;

class Address
{
    public function __construct(
        public ?string $street_name      = null,
        public ?string $street_number    = null,
        public ?string $postal_code      = null,
        public ?string $city             = null
    ) {}
}
