<?php namespace vezit\models\session;
use vezit\models\session\customer\Customer;
use vezit\models\session\order\Order;
use vezit\models\session\shipment\Shipment;
require __DIR__ . '/../../global-requirements.php';

class Session
{
    public function __construct(
        public Customer $customer = new Customer,
        public Order $order = new Order,
        public Shipment $shipment = new Shipment
    )
    {}
}
