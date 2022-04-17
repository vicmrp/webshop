<?php

namespace vezit\dto\class\session\shipment;

require __DIR__ . '/../../../../global-requirements.php'; // __DIR__._from_top_folder().'/

use vezit\dto\class\session\shipment\address\Address;


class Shipment
{

    public function __construct(
        public $tracking_number,
        public $order_collected,
        public $shipment_details_satisfied,
        public Address $address
    ) {}
}
