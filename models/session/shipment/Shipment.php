<?php namespace vezit\models\session\shipment;
use vezit\models\session\shipment\address\Address;
require __DIR__ . '/../../../global-requirements.php';

class Shipment
{

    public function __construct(
        public ?string  $tracking_number                = null,
        public ?bool    $order_collected                = null,
        public ?bool    $details_satisfied_for_payment  = null,
        public ?string  $service_point_id               = null,
        public Address  $address                        = new Address
    ) {}
}
