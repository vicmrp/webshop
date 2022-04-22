<?php

namespace vezit\entities\class\shipment;

require __DIR__ . '/../../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\entities\class\shipment\address\Address;


class Shipment
{

    public function __construct(
        public string $tracking_number = '',
        public bool $order_collected = false,
        public bool $shipment_details_satisfied = false,
        public Address $address = new Address
    ) {}
}
