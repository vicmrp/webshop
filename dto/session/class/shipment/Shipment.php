<?php

namespace vezit\dto\class\session\shipment;

require __DIR__ . '/../../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\dto\class\session\shipment\address\Address;


class Shipment
{

    public function __construct(
        public string $tracking_number = '',
        public bool $order_collected = false,
        public bool $details_satisfied_for_payment = false,
        public Address $address = new Address
    ) {}
}
