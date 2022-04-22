<?php

namespace vezit\dto\session;

require __DIR__ . '/../../global-requirements.php';

use vezit\dto\class\session\customer\Customer as Customer;
use vezit\dto\class\session\order\Order;
use vezit\dto\class\session\shipment\Shipment;



class Session
{

    public function __construct(
        public int $session_id = 0,
        public Customer $customer = new Customer,
        public Order $order = new Order,
        public Shipment $shipment = new Shipment
    )
    { }
}
