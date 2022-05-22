<?php namespace vezit\models;

class Sanitized_Address
{
    public function __construct(
        public ?string $city          = null,
        public ?string $postal_code   = null,
        public ?string $street_name   = null,
        public ?string $street_number = null
    ) {}
}
