<?php namespace vezit\models\sanitized_address;

class Sanitized_Address
{
    public function __construct(
        public ?string $city          = null,
        public ?string $postal_code   = null,
        public ?string $street_name   = null,
        public ?string $street_number = null
    ) {}


    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
