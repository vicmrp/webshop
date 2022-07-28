<?php

namespace vezit\dto;

class Postnord_Service_Point_Response
{
    public function __construct(
        public ?string $service_point_id    = null,
        public ?string $name                = null,
        public ?string $street_name         = null,
        public ?string $street_number       = null,
        public ?string $postal_code         = null,
        public ?string $city                = null,
        public bool $visiting_address       = true
    ) {
    }

    public function __set($name, $value)
    {
        throw new \Exception('Cant set!' . $name . ', ' . $value);
    }
}
