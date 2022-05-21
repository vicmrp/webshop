<?php namespace vezit\dto;

class Postnord_Service_Point_Response
{
    public function __construct(
        public ?int $index         = null,
        public ?string $street_name   = null,
        public ?string $street_number = null,
        public ?string $postal_code   = null,
        public ?string $city          = null
    ) {}

}
