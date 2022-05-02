<?php namespace vezit\dto\internal_dtos\session;
use vezit\dto\internal_dtos\session\customer\Customer;
use vezit\dto\internal_dtos\session\order\Order;
use vezit\dto\internal_dtos\session\shipment\Shipment;
require __DIR__ . '/../../../global-requirements.php';

class Session
{
    public function __construct(
        public ?int $session_id = 0,
        public Customer $customer = new Customer,
        public Order $order = new Order,
        public Shipment $shipment = new Shipment
    )
    {}
}
